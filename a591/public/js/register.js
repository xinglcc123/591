function ajaxRegister() {
	$('#register').val("傳送中");	//更改網頁元素
	var identity = $('input[name="identity"]:checked').val();	//取身份
	$.ajax({
		url: '/ajaxRegister', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'identity': identity,	//身份
			'name': $("#name").val(),	//姓名
			'account': $("#account").val(),	//帳號
			'password': $("#password").val(),	//密碼
			'email': $("#email").val(),	//email
		},
		success: function (res) {	//成功
			if (res) {
				$('#register').val(res['message']); //更改網頁元素
			} else {
				console.log(res);
				$('#register').val("回傳失敗"); //更改網頁元素
			}
		},
		error: function (err) { //失敗
			console.log(err);
			$('#register').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}