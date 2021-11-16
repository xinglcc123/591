<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Manage;
use Illuminate\Http\Request;

class ajaxRegisterController extends Controller
{
	public function ajaxRegister(Request $request)
	{
		$code = '';	//代號
		$message = '';	//訊息	

		// echo $user;
		// exit;

		if ($request['identity'] == '會員') {
			$account = User::where('account', '=', $request['account'])->count();
			$email = User::where('email', '=', $request['email'])->count();
			if ($account) {
				$code = '04';	//代號
				$message = '帳號已被註冊';	//訊息
			} elseif ($email) {
				$code = '05';	//代號
				$message = '信箱已被註冊';	//訊息
			} else {
				User::create([	//新增
					'name' => $request['name'],	//姓名
					'account' => $request['account'],	//帳號
					'password' => $request['password'],	//密碼
					'email' => $request['email'],	//email
				]);
				$code = '01';	//代號
				$message = '會員成功註冊';	//訊息
			}
		} elseif ($request['identity'] == '管理員') {
			$account = Manage::where('account', '=', $request['account'])->count();
			$email = Manage::where('email', '=', $request['email'])->count();
			if ($account) {
				$code = '04';	//代號
				$message = '帳號已被註冊';	//訊息
			} elseif ($email) {
				$code = '05';	//代號
				$message = '信箱已被註冊';	//訊息
			} else {
				Manage::create([	//新增
					'name' => $request['name'],	//姓名
					'account' => $request['account'],	//帳號
					'password' => $request['password'],	//密碼
					'email' => $request['email'],	//email
				]);
				$code = '02';	//代號
				$message = '管理員成功註冊';	//訊息
			}
		}

		// $uid = isset($_SESSION["uid"]) ? $_SESSION["uid"] : '未登入';	//登入id
		return [
			'code' => $code,	//代號
			'message' => $message,	//訊息
			// 'uid' => $uid,	//登入id
		];
	}
}
