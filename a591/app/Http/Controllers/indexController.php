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

class indexController extends Controller
{
	public function __construct()
	{
		$this->client = app(Client::class);
		$this->url = 'https://rent.591.com.tw/';
		$this->urlData = 'https://rent.591.com.tw/home/search/rsList?is_new_list=1&type=1&kind=0&searchtype=1&region=8';
	}

	public function index()
	{
		$i = array();	//測試用
		$products['title'] = empty($_REQUEST['title']) ? '%' : '%' . $_REQUEST['title'] . '%';	//標題
		$products['price'] = empty($_REQUEST['price']) ? array() : $_REQUEST['price'];	//金額
		$products['role_name'] = empty($_REQUEST['role_name']) ? '%' : $_REQUEST['role_name'];	//刊登身分
		$page = empty($_REQUEST['page']) ? '1' : $_REQUEST['page'];
		$pageAmount = 10;
		// laravel搜尋資料庫_關鍵字
		$house = House::where('title', 'like', $products['title']);

		// 代理人
		if ($products['role_name']) {
			$house->where('role_name', 'like', $products['role_name']);
		}

		// 多個租金選擇
		if ($products['price']) {
			$house->where(function ($house) use ($products) {	//使用AND搜尋
				if ($_REQUEST['priceMin'] && $_REQUEST['priceMax']) {
					$house->whereBetween('price', [$_REQUEST['priceMin'], $_REQUEST['priceMax']]);
				} elseif ($_REQUEST['priceMin']) {
					$house->where('price', '>=', $_REQUEST['priceMin']);
				} elseif ($_REQUEST['priceMax']) {
					$house->where('price', '<=', $_REQUEST['priceMax']);
				}
				foreach ($products['price'] as $value) {
					$house->orWhereBetween('price', explode(',', $value));
				}
			});
		}
		// $i = $products['price'];
		info($house->toSql());	//輸出SQL語法到logs\laravel.log
		info($house->getBindings());	//輸出搜尋值到logs\laravel.log

		$house = $house->paginate($pageAmount)
			->toArray();
		//圖片資料轉陣列
		foreach ($house['data'] as $key => $value) {
			$house['data'][$key]['photo_list'] = json_decode($value['photo_list']);
		}
		//切換金額時分頁數量
		// if($house['current_page'] > $house['last_page']) $house['current_page'] = $house['last_page'];
		if ($_REQUEST) {
			return [
				'house' => $house,
				'page' => $page,	//回傳分頁
				'i' => $i,	//測試用
			];
		} else {
			return view('/index', ['house' => $house]);
		}
	}
}
