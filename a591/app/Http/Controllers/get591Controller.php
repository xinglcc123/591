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


use DB;
use App\Http\Controllers\Controller;
use App\Models\House;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

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
		// is_format_data 回傳的格式0,1
		// type 1租,2買
		$this->urlData = "https://rent.591.com.tw/home/search/rsList?is_format_data=1&is_new_list=1&type=1&region=8";
	}

	public function get591()
	{
		$startTime = microtime(true);
		// $test = House::where('id', '>', 1)->delete();
		// $test = House::withTrashed()	//操作軟刪除
		// $test = House::onlyTrashed()	//只操作已軟刪除資料
		//         ->where('deleted_at', '=', '2021-09-28 04:21:02')
		//         ->get();
		// ->restore();	//取消軟刪除
		// echo ($test);
		// exit;
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
		// dd($domData);
		$metas = $domData->getElementsByTagName("meta");	//取得meta欄位
		// dd($metas);
		$csrfToken = '';
		foreach ($metas as $meta) {
			if ($meta->getAttribute('name') == 'csrf-token') {
				$csrfToken = $meta->getAttribute('content');	//取得content元素值
				// echo $meta->getAttribute('content').PHP_EOL;
			}
		}

		$haed = ['X-CSRF-TOKEN' => $csrfToken];	//TOKEN 類似驗證碼
		$firstRow = 30;	//每頁數量
		$i = 0;	//頁數
		$houses = [];	//站存陣列
		do {
			$i++;
			echo "第 $i 頁開始時間 " . (microtime(true) - $startTime) . PHP_EOL;
			$response = $client->request('GET', $this->urlData . '&firstRow=' . $firstRow * $i, [
				'headers' => $haed,
			]);
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

			$post_id = House::pluck('post_id')->all();	//取出所有物件代號
			foreach ($houses as $value) {
				if (in_array($value['post_id'], $post_id)) {	//判斷物件代號是否存在
					House::where('post_id', $value['post_id'])->update($value);	//更新資料
					echo 'update' . $value['post_id'] . PHP_EOL;
				} else {
					House::create($value);		//插入新的
					echo 'new---' . $value['post_id'] . PHP_EOL;
				}
			}
			echo "第 $i 頁結束時間 " . (microtime(true) - $startTime) . PHP_EOL;
		// } while (count($houses) == 30);
		} while ($i < 2);
		

		exit;

	}
}
