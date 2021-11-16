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

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Manage;
use Illuminate\Http\Request;

class headerController extends Controller
{
	public function header(Request $request)
	{
		session_start();
		if (isset($_SESSION["uid"])) {
			// 抓取登入狀態
			$uid = $_SESSION["uid"];	//登入id
			$i = substr($uid, 0, 2);
			if ($i == '01') {
				$account = User::where('account', '=', substr($uid, 2))->get();
			} elseif ($i == '02') {
				$account = Manage::where('account', '=', substr($uid, 2))->get();
			}
			if (!isset($account)) {	// 是否有這位會員
				$uid = '登入異常';
			}
		} else {
			$uid = '登入';
		}
		$logout = '登出';
		return [
			'uid' => $uid,
			'logout' => $logout,
		];
	}
}
