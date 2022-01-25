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
		// info($house->toSql());	// 輸出SQL語法到logs\laravel.log
		// info($house->getBindings());	// 輸出搜尋值到logs\laravel.log

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
		$request['id'] = empty($_REQUEST['id']) ? 234 : $_REQUEST['id'];
		$houseData = House::where('id', '=', $request['id'])->first();
		if ($houseData) {
			$houseData->toArray();
		} else {	// 若找不到則取第一個
			$houseData = House::first()->toArray();
		}
		$house['id'] = $houseData['id'];
		// $house['編號'] = $houseData['post_id'];
		$house['標題'] = $houseData['title'];
		$house['金額'] = $houseData['price'];
		$house['路段'] = $houseData['community'];
		$house['圖片'] = json_decode($houseData['photo_list']);
		// $house['地標'] = $houseData['rent_tag'];
		$house['身份'] = $houseData['role_name'];
		$house['聯絡人'] = $houseData['contact'];
		// $house['區域'] = $houseData['area'];
		$house['樓層'] = $houseData['floor_str'];
		$house['類型'] = $houseData['kind_name'];
		$house['格局'] = $houseData['room_str'];
		// $house['刷新時間'] = $houseData['refresh_time'];
		// $house['地點'] = $houseData['location'];
		// $house['部分名稱'] = $houseData['section_name'];
		// $house['街道名稱'] = $houseData['street_name'];
		// $house['描述'] = $houseData['desc'];
		// $house['距離'] = $houseData['distance'];
		// $house['昨天點擊'] = $houseData['yesterday_hit'];
		// echo var_dump($houseData);
		return view('/modify', [
			'id' => $request['id'],
			'houseData' => $houseData,
			'house' => $house,
		]);
	}

	public function ajaxModify(Request $request)	// 修改
	{
		$house = House::where('id', '=', $request['id'])->first();
		$house->title = $request->title;	//標題
		$house->price = $request->price;	//金額
		$house->community = $request->community;	//路段
		// $house->photo_list = $request->photo_list;	//圖片
		$house->role_name = $request->role_name;	//身份
		$house->contact = $request->contact;	//聯絡人
		$house->floor_str = $request->floor_str;	//樓層
		$house->kind_name = $request->kind_name;	//類型
		$house->room_str = $request->room_str;	//格局
		$house->save();
		return [
			'id' => $request->id,
			'house' => $house,
			'request' => $request->all(),
		];
	}

	public function ajaxAddImg(Request $request)	// 新增圖片
	{
		if ($request->file('myfile') == null) {
			return [
				'message' => '未上傳檔案',
			];
		}
		$myfile = $request->file('myfile');
		if ($myfile->isValid()) {	//確定上傳的文件是否有效
			if (file_exists("/public/server/img/" . $myfile->getClientOriginalName())) {
				return [
					'message' => '檔案已存在',
				];
			}
			// $data[] = $myfile->getRealPath();	//上傳路徑
			$data[] = $myfile->getClientOriginalExtension();	//文件副檔名
			$data[] = $myfile->getClientOriginalName();	//文件名稱
			$data[] = $myfile->getSize() / 1024 . ' Kb';	//文件大小
			move_uploaded_file($myfile, "/public/server/img/" . $myfile->getClientOriginalName());
			return [
				'message' => '上傳成功',
				'data' => $data,
			];
		} else {
			return [
				'message' => '上傳失敗',
			];
		}


		if ($_FILES["img"]["error"] > 0) {
			$message .= "Error: " . $_FILES["img"]["error"];
		} else {
			$message .= "檔案名稱: " . $_FILES["img"]["name"] . "<br/>";
			$message .= "檔案類型: " . $_FILES["img"]["type"] . "<br/>";
			$message .= "檔案大小: " . ($_FILES["img"]["size"] / 1024) . " Kb<br />";
			$message .= "暫存名稱: " . $_FILES["img"]["tmp_name"] . "<br/>";
			if (file_exists("public/server/img" . $_FILES["img"]["name"])) {
				$message .= "檔案已經存在，請勿重覆上傳相同檔案";
			} else {
				//在檔名不會有中文的情況下，可以直接 move_uploaded_file
				//move_uploaded_file($_FILES["img"]["tmp_name"],"public/server/img".$_FILES["img"]["name"]);
				//在無法判斷檔名是否有中文的情況下，建議使用此方法(iconv( 原來的編碼 , 轉換的編碼 , 轉換的字串 ))避免掉中文檔名無法上傳的問題
				$target_path = "public/server/img"; //指定上傳資料夾
				$target_path .= $_FILES['img']['name']; //上傳檔案名稱
				if (move_uploaded_file($_FILES['img']['tmp_name'], iconv("UTF-8", "big5", $target_path))) {
					$message .= "檔案：" . $_FILES['img']['name'] . " 上傳成功!";
				} else {
					$message .= "檔案上傳失敗，請再試一次!";
				}
				return [
					'message' => $message,
				];
			}
		}
	}

	public function add(Request $request)	// 新增頁面
	{
		$data = scandir("/public/server/img/");
		foreach ($data as $value) {
			if (!($value == '.' || $value == '..')) {
				unlink("/public/server/img/" . $value);
			}
		}
		return view('/add', [
			'test' => 'test',
		]);
	}

	public function ajaxAdd(Request $request)	// 新增頁面
	{
		// $house = House::where('id', '=', $request['id'])->first();
		// $house->title = $request->title;	//標題
		// $house->price = $request->price;	//金額
		// $house->community = $request->community;	//路段
		// $house->photo_list = $request->photo_list;	//圖片
		// $house->role_name = $request->role_name;	//身份
		// $house->contact = $request->contact;	//聯絡人
		// $house->floor_str = $request->floor_str;	//樓層
		// $house->kind_name = $request->kind_name;	//類型
		// $house->room_str = $request->room_str;	//格局
		// $house->save();

		$house = House::create([
			'title' => $request->title,
			'price' => $request->price,
			'community' => $request->community,
			'photo_list' => json_encode($request->photo_list),
			'role_name' => $request->role_name,
			'contact' => $request->contact,
			'floor_str' => $request->floor_str,
			'kind_name' => $request->kind_name,
			'room_str' => $request->room_str,
		]);
		return [
			'request' => $request,
			'house' => $house,
		];
	}
}
