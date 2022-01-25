<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Cookie\SessionCookieJar;

$rsList_url = 'https://rent.591.com.tw/home/search/rsList?is_new_list=1&type=1&kind=0&searchtype=1';
$regions = [
/*  1 => [ 'region_name' => '台北市' ],
	2 => [ 'region_name' => '基隆市' ],
	3 => [ 'region_name' => '新北市' ],
	4 => [ 'region_name' => '新竹市' ],
	5 => [ 'region_name' => '新竹縣' ],
	6 => [ 'region_name' => '桃園市' ], */
/* 	7 => [ 'region_name' => '苗栗縣' ],
	8 => [ 'region_name' => '台中市' ],
	10 => [ 'region_name' => '彰化縣' ],
	11 => [ 'region_name' => '南投縣' ],
	12 => [ 'region_name' => '嘉義市' ],
	13 => [ 'region_name' => '嘉義縣' ],
	14 => [ 'region_name' => '雲林縣' ],
	15 => [ 'region_name' => '台南市' ],
	17 => [ 'region_name' => '高雄市' ],
	19 => [ 'region_name' => '屏東縣' ],
	21 => [ 'region_name' => '宜蘭縣' ],
	22 => [ 'region_name' => '台東縣' ],
	23 => [ 'region_name' => '花蓮縣' ], */
	24 => [ 'region_name' => '澎湖縣' ],
	25 => [ 'region_name' => '金門縣' ],
    26 => [ 'region_name' => '連江縣' ],
];
$poolSize = 1;

function multi_guzzle_req(&$client, &$request_array, $poolSize)
{
	$results = [];
	
	$requestGenerator = function() use ($client, $request_array) {
		foreach ($request_array as $request)
		{
			$url = $request['url'];
			$headers = $request['headers'];
			
			yield function() use ($client, $url, $headers) {
				return $client->requestAsync('GET', $url, ['headers' => $headers]);
			};
		}
	};
	
	$pool = new Pool($client, $requestGenerator(), [
		'concurrency' => $poolSize,
		'fulfilled' => function ($response, $index) use (&$results, &$request_array) {
			$request = $request_array[$index];
			$results[$index] = ['request' => $request, 'response' => $response->getBody()->getContents()];
		},
		'rejected' => function ($reason, $index) {
			echo "Requested search term: ", $index, "\n";
			echo $reason->getMessage(), "\n\n";
		},
	]);
	
	$promise = $pool->promise();
	$promise->wait();
	
	return $results;
}



// get csrf token and cookies
$headers = array(
	'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36'
);

$client = new Client();
$res = $client->request('GET', "https://rent.591.com.tw/", [
	'headers' => $headers,
]);
$page = $res->getbody()->getcontents();

$dom = new DOMDocument;
libxml_use_internal_errors(true);
$dom->loadHTML($page);
libxml_use_internal_errors(false);
$xpath = new DOMXPath($dom);
$node_list = $xpath->query("//meta[@name='csrf-token']");
$csrf_token = $node_list[0]->getAttribute('content');

$cookies = array();
foreach($res->getHeader('Set-Cookie') as $line) {
	foreach(explode('; ', $line) as $item)
	{
		parse_str($item, $cookie);
		$cookies = array_merge($cookies, $cookie);
	}
}
unset($cookies['urlJumpIpByTxt']);

foreach ($regions as $regionid => $region)
{
	$cookies['urlJumpIp'] = $regionid;
	$cookie = implode('; ', array_map( function ($v, $k) { return "$k=$v"; }, $cookies, array_keys($cookies)));
	$headers = array(
		"Accept" => "application/json, text/javascript, */*; q=0.01",
		"X-CSRF-TOKEN" => $csrf_token,
		"Cookie" => $cookie,
	);
	$regions[$regionid]['headers'] = $headers;
}


$rows = [];
// first: crawl first page and estimate page size
$requests = [];
foreach ($regions as $regionid => $region)
{
	$url = $rsList_url . "&region=$regionid" . "&firstRow=0";
	$headers = $region['headers'];
	
	$requests[] = ['url'=>$url, 'headers'=>$headers];
}

$results = multi_guzzle_req($client, $requests, $poolSize);
foreach ($results as $result)
{
	$data = json_decode($result['response'], true);
	foreach($data['data']['data'] as $row)
	{
		$rows[] = $row;
	}
	$records = str_replace(',', '', $data['records']);
	
	$quey_string = parse_url($result['request']['url'])['query'];
	parse_str($quey_string, $params);
	$regionid = $params['region'];
	$page_size = ceil($records / 30);
	$regions[$regionid]['page_size'] = $page_size;
}


// remained pages
$requests = [];
foreach ($regions as $regionid => $region)
{
	$page_size = $region['page_size'];
	$headers = $region['headers'];
	
	if ($page_size > 1)
	{
		for ($i = 1; $i <= $page_size; $i++)
		{
			$url = $rsList_url . "&firstRow=" . 30*($i-1);
			$requests[] = ['url'=>$url, 'headers'=>$headers, 'regionid' => $regionid];
		}
	}
}

$results = multi_guzzle_req($client, $requests, $poolSize);
foreach ($results as $result)
{
	$data = json_decode($result['response'], true);
	foreach($data['data']['data'] as $row)
	{
		$rows[] = $row;
	}
}


// insert database
$pdo = new PDO("mysql:host=localhost;dbname=591", 'root', '');
$pdo->query("set names utf8");

foreach ($rows as $row)
{
	$rent_id     = $row['id'];
	$title       = $row['address_img_title'];
	$address     = $row['location'];
	$publisher   = $row['nick_name'];
	$floor       = $row['floorStr'];
	
	# 租金（有例外，如：5,000~6,000）只取最大值
	$rent_price  = max(array_map( function ($price) { return str_replace(',', '', $price); }, array_filter(explode('~', $row['price'])) ));
	
	$category_id = $row['kind'];
	$region_id   = $row['regionid'];
	$section_id  = $row['sectionid'];
	$photoList   = $row['photoList'];
	
	$keyArr = implode(", ", ['rent_id', 'title', 'address', 'publisher', 'floor', 'rent_price', 'category_id', 'region_id', 'section_id', 'created_at', 'updated_at']);
	$valArr = "'" . implode("', '", [$rent_id, $title, $address, $publisher, $floor, $rent_price, $category_id, $region_id, $section_id]) . "'" . ", now()" . ", now()";;
	
	$sql = "SELECT rent_id FROM products WHERE rent_id = '" . $rent_id . "'";
	$query = $pdo->query($sql);
	$r = $query->fetchAll();
	if (count($r) > 0)
	{
		// 不做更新，资料只抓一次
		
		// $sql = "UPDATE $tableName SET $kvArr WHERE $PrimaryKey = '" . $$PrimaryKey . "'";
		// $db->query($sql);
	} else
	{
		$sql = "INSERT INTO products($keyArr) values($valArr)";
		$pdo->exec($sql);
		
		$product_id = $pdo->lastInsertId();
		
		foreach ($photoList as $path)
		{
			$sql = "INSERT INTO images(path, product_id, created_at, updated_at) values('$path', '$product_id', now(), now())";
			$pdo->exec($sql);
		}
		
	}
	
}

// 问题：资料都会有更新变动发生，写入资料库唯一 key 很重要
// 图片怎么办（不想抓下来...）
