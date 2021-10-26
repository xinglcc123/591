<?php
/*curl guzzle(PHP HTTP 请求套件) 兩個版本
位置 分類 名稱 租金 商品照(含內頁圖) 存進 DB
laravel專案 會員系統+產品架
後臺可以針對抓下來的這些資料做編輯
只有管理員可以進後台 會員只能登入前台
前台要能顯示那些資料 分頁 搜尋 都要有
產品架是兩層
分類+商品 圖片也要跟商品做關聯 統一使用restful api格式
資料抓一次性 手動下玩指令存DB
*/
// address
// price
// filename
// cover
// regionname
// sectionname
// ltime


// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Routing\Controller as BaseController;

namespace App\Http\Controllers;
// use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;


use DB;
use App\Http\Controllers\Controller;
use App\Models\House;

class get591Controller extends Controller
{
	public function __construct()
	{
		$rentpricemin = 5000;	//最低租金
		$rentpricemax = 10000;	//最高租金
		$multiRoom = 1;	//房型
		$section = 102;	//區域
		$this->client = app(Client::class);
		$this->url = 'https://rent.591.com.tw/';
		// $this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&type=1";
		// is_format_data 回傳的格式0,1
		// is_new_list 未知
		// type 1租,2買
		// firstRow 開始的筆數
		// totalRows 總筆數
		// $this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&region=1&mrtline=100&mrtcoods=4314,4257&searchtype=4";
		// $this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&region=1&mrtline=125&mrtcoods=4198,4163&searchtype=4";
		$this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&region=1&mrtline=195&mrtcoods=4169&searchtype=4";
	}

	public function get591()
	{
		
		// $test = House::where('id', '>', 1)->delete();
		// $test = House::withTrashed()	//操作軟刪除
		// $test = House::onlyTrashed()	//只操作已軟刪除資料
        //         ->where('deleted_at', '=', '2021-09-28 04:21:02')
        //         ->get();
                // ->restore();	//取消軟刪除
		// echo ($test);
		// exit;
		$client = new Client(array(
			'cookies' => true
		));
		$response = $client->request('GET', $this->url);
		exit;
		$body = $response->getbody()->getcontents();	//抓body
		$domData = new \DOMDocument();
		@$domData->loadHTML($body);
		// dd($domData);
		$metas = $domData->getElementsByTagName("meta");	//取得meta欄位
		// dd($metas);
		$csrfToken = '';
		foreach ($metas as $meta) {
			if ($meta->getAttribute('name') == 'csrf-token') {
				$csrfToken = $meta->getAttribute('content');	//取得content值
			}
		}

		$haed = ['X-CSRF-TOKEN' => $csrfToken];	//TOKEN 類似驗證碼
		$firstRow = 30;
		$i = 0;
		do {
			// dd($this->urlData . '&firstRow=' . $firstRow * $i);
			$response = $client->request('GET', $this->urlData . '&firstRow=' . $firstRow * $i , [
				'headers' => $haed,
			]);
			$i++;
			$body = $response->getbody()->getcontents();	//抓body
			$data = json_decode($body, true)['data']['data'];	//抓取需要的資料
			// dd($data);

			$houses = [];
			foreach ($data as $key => $value) {
				// $imgUrl = 'https://rent.591.com.tw/home/business/getPhotoList?post_id=' . $value['regionname'] . '&type=1';
				// $response = $client->request('GET', $imgUrl, [
				// 	'headers' => $haed,
				// ]);
				// $body = $response->getbody()->getcontents();	//抓body
				// return($response);
				// exit;
				// House::create(
				// 	[
				// 		"regionname" => $value['regionname'],
				// 		"sectionname" => $value['sectionname'],
				// 		"address" => $value['address'],
				// 		"price" => str_replace(',', '', $value['price']),
				// 		"filename" => $value['filename'],
				// 		"ltime" => $value['ltime'],
				// 	],
				// );
				// echo json_encode($value['rent_tag'], 320) . '<br>';
				// exit;
				$houses[$key]['post_id'] = $value['post_id'];	// 物件代號
				$houses[$key]['title'] = $value['title'];	// 標題
				$houses[$key]['price'] = str_replace(',', '', $value['price']);	// 租金
				$houses[$key]['community'] = $value['community'];	// 地點
				$houses[$key]['photo_list'] = json_encode($value['photo_list'], 64);	//圖片,陣列(JSON_UNESCAPED_SLASHES)
				$houses[$key]['rent_tag'] = json_encode($value['rent_tag'], 320);	//特色標籤,陣列(JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE)
				$houses[$key]['role_name'] = $value['role_name'];	// // 出租人身分
				$houses[$key]['contact'] = $value['contact'];	// 出租人名稱
				$houses[$key]['area'] = $value['area'];	// 坪數
				$houses[$key]['floor_str'] = $value['floor_str'];	// 樓層
				$houses[$key]['kind_name'] = $value['kind_name'];	// // 類型
				$houses[$key]['room_str'] = $value['room_str'];	// 格局
				$houses[$key]['refresh_time'] = $value['refresh_time'];	// 更新時間
				$houses[$key]['location'] = $value['location'];	// 位置
				$houses[$key]['section_name'] = $value['section_name'];	// 所在區域
				$houses[$key]['street_name'] = $value['street_name'];	// 所在路段
				$houses[$key]['desc'] = isset($value['surrounding']['desc']) ? $value['surrounding']['desc'] : null;	// 附近地標
				$houses[$key]['distance'] = isset($value['surrounding']['distance']) ? $value['surrounding']['distance'] : null;	// 附近地標距離
				$houses[$key]['yesterday_hit'] = $value['yesterday_hit'];	// 昨日瀏覽人數

				$date = date("Y-m-d h:i:s");	//SQL datetime格式
				$houses[$key]['created_at'] = $date;	//使用原生的插入語句，Laravel不會自動插入created_at和updated_at字段。
				$houses[$key]['updated_at'] = $date;	//使用原生的插入語句，Laravel不會自動插入created_at和updated_at字段。
				echo json_encode($houses[$key], 320) . '<br>' . PHP_EOL;
			}
			// dd($houses);
			// House::where('id', 2)
			//   ->delete();

			// House::create(	//不能輸入陣列
			House::insert(	//原生的插入語句輸入陣列
				$houses,
			);
		
		// } while (count($houses) == 30);
		} while ($i <= 2);
		// dd($data);
		exit;


		
		// dd($headers);
		// dd($body);

		//取得usertoken
		// echo implode(" ", $headers['Set-Cookie']); 
		// $responseData = ($response->getBody()->getContents());
		// var_dump(json_decode($responseData, true));
		// $arrayLoginData = json_decode($responseData, true);
		// echo $arrayLoginData;
		// dd($response);
		//捞资料
		$responseData = $client->request('GET', $this->urlData, [
			// $headers,
			'headers' => [
				'usertoken' => $headers['Set-Cookie'],
			],
			// 'form_params' => [
			// 'json' => [
			'query' => [
				'is_new_list' => '1',
				'type' => '1',
				'kind' => '0',
				'searchtype' => '1',
				'region' => '8',
				'keywords' => '西屯區',
			]
		]);
		$headData = $responseData->getHeaders();
		echo $headData;

		exit;


		// $client = new Client;
		$response = $this->client->request('GET', $this->url);
		dd($response);
		exit;

		$jar = new CookieJar();

		$client = new Client([
			'cookies' => $jar
		]);
		//登入
		$responseLogin = $client->request('POST', $url, [
			'form_params' => []
		]);

		//取得usertoken
		$responseData = ($responseLogin->getBody()->getContents());
		var_dump(json_decode($responseData, true));
		$arrayLoginData = json_decode($responseData, true);
		echo $arrayLoginData;
		exit;

		$a = $this->curl();
		// print_r($a);
		$b = json_decode($a, true);
		// echo $b['recommend'];
		echo json_encode($b['recommend'], JSON_UNESCAPED_UNICODE);
		// $results = DB::select('select * from get591 where id = 1', array(1));

		// 'mysql' => [
		//     'read' => [
		//         'host' => '127.0. 0.1',
		//     ],
		//     'write' => [
		//         'host' => '196.168.1.2'
		//     ],
		//     'driver'    => 'mysql',
		//     'database'  => 'database',
		//     'username'  => 'root',
		//     'password'  => '',
		//     'charset'   => 'utf8',
		//     'collation' => 'utf8_unicode_ci',
		//     'prefix'    => '',
		// ],
		// $link = mysql_connect("127.0.0.1", "root", "");

		// if (!$link) {
		//     die("無法建立連線");
		// }

		return view('591');
	}

	public function curl()
	{
		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://rent.591.com.tw/home/search/rsList?is_new_list=1&type=1&kind=0&searchtype=1&region=8&keywords=%E8%A5%BF%E5%B1%AF%E5%8D%80',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Accept:  application/json, text/javascript, */*; q=0.01',
				'Accept-Encoding:  gzip, deflate, br',
				'Accept-Language:  zh-TW,zh-CN;q=0.9,zh;q=0.8,en-US;q=0.7,en;q=0.6,und;q=0.5,ja;q=0.4',
				'Connection:  keep-alive',
				'Cookie:  T591_TOKEN=6b33hr5vc275qclcuaoggk3no1; user_index_role=1; _ga=GA1.3.470459099.1628933767; __auc=8ebb61dc17b4404bf58c32eb33c; tw591__privacy_agree=1; is_new_index=1; is_new_index_redirect=1; urlJumpIpByTxt=%E5%8F%B0%E4%B8%AD%E5%B8%82; urlJumpIp=8; webp=1; PHPSESSID=mjelo51h5ijukjt8tst52l8ba7; bid[pc][13.78.85.146]=3228; _gid=GA1.3.1434170864.1632447744; user_sessionid=mjelo51h5ijukjt8tst52l8ba7; index_keyword_search_analysis=%7B%22role%22%3A%221%22%2C%22type%22%3A%229%22%2C%22keyword%22%3A%22%E8%A5%BF%E5%B1%AF%E5%8D%80%22%2C%22selectKeyword%22%3A%22%22%2C%22menu%22%3A%22%22%2C%22hasHistory%22%3A1%2C%22hasPrompt%22%3A0%2C%22history%22%3A0%7D; marketSearchHistory=%5B%7B%22search_type%22%3A5%2C%22sectionid%22%3A104%7D%5D; user_browse_recent=a%3A5%3A%7Bi%3A0%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2211440384%22%3B%7Di%3A1%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2211361379%22%3B%7Di%3A2%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2211334558%22%3B%7Di%3A3%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2211401520%22%3B%7Di%3A4%3Ba%3A2%3A%7Bs%3A4%3A%22type%22%3Bi%3A1%3Bs%3A7%3A%22post_id%22%3Bs%3A8%3A%2211403983%22%3B%7D%7D; last_search_type=1; 591_new_session=eyJpdiI6IklLamhSeUFidkFrYUZrV1o2VUQ4SEE9PSIsInZhbHVlIjoiS29HTFZXeXZjQm94UzZPZ0I3dDc4T0w1VkkxMlVNK21mR0dhenVPU2UrUTNCMXlIT0p4cm9kb1U1OXVvNFoxZVdZVXhTQUNsR0FUUzRqSVllOFU3WEE9PSIsIm1hYyI6IjAwYzkyYjYxNWI2ZjMzOGIxYTY2MzYwNjlkZmFhNTczNzJjNDUzYzBiM2IzNTJmMGQwODFmMjQyNjQyZDBiOTEifQ%3D%3D; new_rent_list_kind_test=0',
				'Host:  rent.591.com.tw',
				'Referer:  https://rent.591.com.tw/?kind=0&region=8&keywords=%E8%A5%BF%E5%B1%AF%E5%8D%80',
				'sec-ch-ua:  "Google Chrome";v="93", " Not;A Brand";v="99", "Chromium";v="93"',
				'sec-ch-ua-mobile:  ?0',
				'sec-ch-ua-platform:  "Windows"',
				'Sec-Fetch-Dest:  empty',
				'Sec-Fetch-Mode:  cors',
				'Sec-Fetch-Site:  same-origin',
				'User-Agent:  Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.63 Safari/537.36',
				'X-CSRF-TOKEN:  gqjhYpocut5H4up74EfOBrubTlg7L26GGSqS9smp',
				'X-Requested-With:  XMLHttpRequest'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}
}
