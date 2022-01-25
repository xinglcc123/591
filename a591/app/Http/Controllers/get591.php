<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\House;
use GuzzleHttp\Client;

use DB;

class get591 extends Controller
{
	public function __construct()
	{
		// $this->client = app(Client::class);
		// $this->url = 'https://rent.591.com.tw/';
		// is_format_data 回傳的格式0,1
		// type 1租,2買
		// $this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&region=8";
	}

	public function get591()
	{

		$ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, "https://www.591.com.tw/");
		curl_setopt($ch, CURLOPT_URL, "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&keywords=%E8%A5%BF%E5%B1%AF%E5%8D%80");
		$page = curl_exec($ch);
		curl_close($ch);

		echo $page;
		exit;

		libxml_use_internal_errors(true);
		$dom->loadHTML($page);
		libxml_use_internal_errors(false);
		$xpath = new DOMXPath($dom);
		$node_list = $xpath->query("//meta[@name='csrf-token']");
		$csrf_token = $node_list[0]->getAttribute('content');
		exit;

		preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $page, $matches);
		$cookies = array();
		foreach ($matches[1] as $item) {
			parse_str($item, $cookie);
			$cookies = array_merge($cookies, $cookie);
		}
		unset($cookies['urlJumpIpByTxt']);
		exit;

		$headers = array(
			'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36'
		);
		$client = new Client(array(
			'headers' => $headers,
			'cookies' => true
		));
		$response = $client->request('GET', $this->url);
		// exit;
		$body = $response->getbody()->getcontents();	//抓body
		$domData = new \DOMDocument();
		@$domData->loadHTML($body);
		$metas = $domData->getElementsByTagName("meta");	//取得meta欄位
		$csrfToken = '';
		foreach ($metas as $meta) {
			if ($meta->getAttribute('name') == 'csrf-token') {
				$csrfToken = $meta->getAttribute('content');	//取得content值
			}
		}

		$haed = ['X-CSRF-TOKEN' => $csrfToken];	//TOKEN 類似驗證碼
		$firstRow = 30;	//每頁數量
		$i = 0;	//頁數
		$houses = [];	//暫存陣列
		$startTime = microtime(true);
		do {
			$response = $client->request('GET', $this->urlData . '&firstRow=' . $firstRow * $i, [
				'headers' => $haed,
			]);
			$i++;
			$body = $response->getbody()->getcontents();	//抓body
			$data = json_decode($body, true)['data']['data'];	//抓取需要的資料

			foreach ($data as $key => $value) {
				$houses[$key]['post_id'] = $value['post_id'];	// 物件代號
				$houses[$key]['title'] = $value['title'];	// 標題
				$price = (explode("~", str_replace(',', '', $value['price']))); //先替換, 轉陣列
				$houses[$key]['price'] = $price[0];	// 租金
				$houses[$key]['community'] = $value['community'];	// 地點
				$houses[$key]['photo_list'] = json_encode($value['photo_list'], 64);	//圖片,陣列(JSON_UNESCAPED_SLASHES)
				$houses[$key]['rent_tag'] = json_encode($value['rent_tag'], 320);	//特色標籤,陣列(JSON_UNESCAPED_SLASHES+JSON_UNESCAPED_UNICODE)
				$houses[$key]['role_name'] = $value['role_name'];	// 出租人身分
				$houses[$key]['contact'] = $value['contact'];	// 出租人名稱
				$houses[$key]['area'] = $value['area'];	// 坪數
				$houses[$key]['floor_str'] = $value['floor_str'];	// 樓層
				$houses[$key]['kind_name'] = $value['kind_name'];	// 類型
				$houses[$key]['room_str'] = $value['room_str'];	// 格局
				$houses[$key]['refresh_time'] = $value['refresh_time'];	// 更新時間
				$houses[$key]['location'] = $value['location'];	// 位置
				$houses[$key]['section_name'] = $value['section_name'];	// 所在區域
				$houses[$key]['street_name'] = $value['street_name'];	// 所在路段
				$houses[$key]['desc'] = isset($value['surrounding']['desc']) ? $value['surrounding']['desc'] : null;	// 附近地標
				$houses[$key]['distance'] = isset($value['surrounding']['distance']) ? $value['surrounding']['distance'] : null;	// 附近地標距離
				$houses[$key]['yesterday_hit'] = $value['yesterday_hit'];	// 昨日瀏覽人數
			}
			echo 'getEndTime '.(microtime(true) - $startTime) . '<br/>';

			$post_id = House::pluck('post_id')->all();	//取出所有物件代號
			foreach ($houses as $value) {
				if (in_array($value['post_id'], $post_id)) {	//判斷物件代號是否存在
					House::where('post_id', $value['post_id'])->update($value);	//更新資料
					echo 'update' . $value['post_id'] . '</br>';
				} else {
					House::create($value);		//插入新的
					echo 'new---' . $value['post_id'] . '</br>';
				}
			}
			echo 'sqlEndTime '.(microtime(true) - $startTime) . '<br/>';
			// echo count($houses) . '<br/>';

		} while (count($houses) == 30);
		// } while ($i < 2);
		

		exit;

	}
}

