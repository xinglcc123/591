<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Manage;
use Illuminate\Http\Request;

class ajaxLoginController extends Controller
{
	public function ajaxLogin(Request $request)
	{
		session_start();
		if ($request['identity'] == '會員') {
			$account = User::where('account', '=', $request['account'])->get();
			if (isset($account[0])) {
				if ($account[0]['password'] == $request['password']) {
					$code = '06';	//代號
					$message = '登入成功';	//訊息
					$_SESSION["uid"] = '01' . $account[0]['account'];	//登入狀態
				} else {
					$code = '07';	//代號
					$message = '密碼錯誤';	//訊息
				}
			} else {
				$code = '08';	//代號
				$message = '無此帳號';	//訊息
			}
		} elseif ($request['identity'] == '管理員') {
			$account = Manage::where('account', '=', $request['account'])->get();
			if (isset($account[0])) {
				if ($account[0]['password'] == $request['password']) {
					$code = '06';	//代號
					$message = '登入成功';	//訊息
					$_SESSION["uid"] = '02' . $account[0]['account'];	//登入狀態
				} else {
					$code = '07';	//代號
					$message = '密碼錯誤';	//訊息
				}
			} else {
				$code = '08';	//代號
				$message = '無此帳號';	//訊息
			}
		}

		$uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : '登入';	//登入id
		return [
			'code' => $code,	//代號
			'message' => $message,	//訊息
			'uid' => $uid,	//登入id
		];
	}
	public function ajaxLogout(Request $request)
	{
		session_start();
		unset($_SESSION["uid"]);	//移除id
		$code = '10';	//代號
		$message = '成功登出';	//訊息
		$uid = '登入';
		return [
			'code' => $code,	//代號
			'message' => $message,	//訊息
			'uid' => $uid,	//登入id
		];
	}
}
