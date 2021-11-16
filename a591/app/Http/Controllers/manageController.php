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


// 新增刪除修改 要分會員跟管理員 enter要能用 request改laravel

namespace App\Http\Controllers;
// use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

use DB;
use App\Http\Controllers\Controller;
use App\Models\House;
use Illuminate\Http\Request;

class manageController extends Controller
{
	public function manage(Request $request)
	{
		$products['title'] = empty($request['title']) ? '%' : '%' . $request['title'] . '%';	// 標題
		$products['price'] = empty($request['price']) ? array() : $request['price'];	// 金額
		$products['role_name'] = empty($request['role_name']) ? '%' : $request['role_name'];	// 刊登身分
		$page = empty($request['page']) ? '1' : $request['page'];
		$pageAmount = 10;
		// laravel搜尋資料庫_關鍵字
		$house = House::where('title', 'like', $products['title']);

		// 代理人
		if ($products['role_name']) {
			$house->where('role_name', 'like', $products['role_name']);
		}

		// 多個租金選擇
		if ($products['price']) {
			$house->where(function ($house) use ($products, $request) {	// 使用AND搜尋
				if ($request['priceMin'] && $request['priceMax']) {
					$house->whereBetween('price', [$request['priceMin'], $request['priceMax']]);
				} elseif ($request['priceMin']) {
					$house->where('price', '>=', $request['priceMin']);
				} elseif ($request['priceMax']) {
					$house->where('price', '<=', $request['priceMax']);
				}
				foreach ($products['price'] as $value) {
					$house->orWhereBetween('price', explode(',', $value));
				}
			});
		}
		info($house->toSql());	// 輸出SQL語法到logs\laravel.log
		info($house->getBindings());	// 輸出搜尋值到logs\laravel.log

		$house = $house->paginate($pageAmount)
			->toArray();
		// 圖片資料轉陣列
		foreach ($house['data'] as $key => $value) {
			$house['data'][$key]['photo_list'] = json_decode($value['photo_list']);
		}
		// 切換金額時分頁數量
		// if($house['current_page'] > $house['last_page']) $house['current_page'] = $house['last_page'];
		// $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : '未登入';	//登入id
		if ($_REQUEST) {
			return [
				'house' => $house,
				'page' => $page,	// 回傳分頁
				// 'uid' => $uid,
			];
		} else {
			return view('/manage', ['house' => $house]);
		}
	}

	public function ajaxDelete(Request $request)	// 刪除
	{
		$house = House::where('id', 'like', $request['id'])->delete();
		return [
			'id' => $request['id'],
			'house' => $house,
		];
	}

	public function modify(Request $request)
	{
		// $id = $request['id'];
		// if ($_REQUEST) {
		// 	return [
		// 		'house' => $house,
		// 		'page' => $page,	// 回傳分頁
		// 		// 'uid' => $uid,
		// 	];
		// } else {
			return view('/modify', [
				'id' => $request['id'],
			]);
		// }
	}

	public function ajaxModify(Request $request)	// 修改
	{
		$house = House::where('id', 'like', $request['id'])->get();
		return [
			'id' => $request['id'],
			'house' => $house,
		];
	}
}
