function ajaxLogin() {
	$('#login').val("傳送中");	//更改網頁元素
	var identity = $('input[name="identity"]:checked').val();	//取身份
	$.ajax({
		url: '/ajaxLogin', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'identity': identity,	//身份
			'account': $("#account").val(),	//帳號
			'password': $("#password").val(),	//密碼
		},
		success: function (res) {	//成功
			if (res) {
				$('#login').html(res['uid']);	// 登入狀態
				$('#logingo').val(res['message']); //更改網頁元素
			} else {
				console.log(res);
				$('#logingo').val("回傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#login').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}

function ajaxLogout() {
	$('#login').val("傳送中");	//更改網頁元素
	var identity = $('input[name="identity"]:checked').val();	//取身份
	$.ajax({
		url: '/ajaxLogout', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'identity': identity,	//身份
			'account': $("#account").val(),	//帳號
			'password': $("#password").val(),	//密碼
		},
		success: function (res) {	//成功
			if (res) {
				$('#login').html(res['uid']);	// 登入狀態
			} else {
				console.log(res);
				$('#logingo').val("回傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#login').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}