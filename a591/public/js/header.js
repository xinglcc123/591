// X-CSRF-TOKEN
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$.ajax({
	url: '/header', //傳送頁面
	type: 'POST', //傳送方式
	data: {
	},
	success: function (res) { //成功
		if (res) {
			$('#login').html(res['uid']);	// 登入狀態
			$('#logout').html(res['logout']);	// 登出按鈕
		} else {
			alert("回傳失敗");
		}
	},
	error: function () { //失敗
		alert("發生錯誤");
	}
});