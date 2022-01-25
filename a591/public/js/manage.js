// var pathname = $(location).attr('pathname');
// console.log(pathname);
if ($(location).attr('pathname') == '/manage') {	// 後台首頁
	getManage();
} else if ($(location).attr('pathname') == '/modify') {
	getModify();
}


//點擊分頁
$(`ul li a`).each(function () {
	$(this).click(function () { //點擊觸發
		getManage($(this).val()); //執行並帶入值
	})
})

//點擊租金區間
$(`tr td input[name="price"]`).each(function () {
	$(this).click(function () { //點擊觸發
		getManage(1); //執行並帶入值
	})
})

//點擊刊登身分
$(`tr td input[name="role_name"]`).each(function () {
	$(this).click(function () { //點擊觸發
		getManage(1); //執行並帶入值
	})
})

//二合一
// $(`tr td input[name="price"]` || `tr td input[name="role_name"]`).each(function() {
// 	$(this).click(function() {	//點擊觸發
// 		getManage(1);	//執行並帶入值
// 	})
// })

function getManage(repage) {
	// console.log($('form').serialize());
	$('#postForm').val("傳送中..."); //更改網頁元素
	var price = $('input[name="price"]:checked').map(function () { //取金額
		return this.value;
	}).get()

	$.ajax({
		url: '/index', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'title': $("#title").val(), //標題
			'price': price, //金額
			'priceMin': $("#priceMin").val(), //最小金額
			'priceMax': $("#priceMax").val(), //最大金額
			'role_name': $('input[name=role_name]:checked').val(), //刊登身分
			'page': repage, //頁數
		},
		success: function (res) { //成功
			if (res) {
				var str = ``;
				var imgStr = ``; //放圖片
				var label = ``;
				var page = res['house']['current_page']; //目前頁面

				// jquery更新分頁欄位
				$('ul li a[name="getPage01"]').html(`第` + 1 + `頁`).val(1).show();
				(page <= 1) ? $('ul li a[name="getPage02"]').val(page - 1).hide() : $('ul li a[name="getPage02"]').val(page - 1).show();
				(page <= 2) ? $('ul li a[name="getPage03"]').html(page - 2).val(page - 2).hide() : $('ul li a[name="getPage03"]').html(page - 2).val(page - 2).show();
				(page <= 1) ? $('ul li a[name="getPage04"]').html(page - 1).val(page - 1).hide() : $('ul li a[name="getPage04"]').html(page - 1).val(page - 1).show();
				$('ul li a[name="getPage05"]').html(page).val(page);
				(res['house']['last_page'] - 1 < page) ? $('ul li a[name="getPage06"]').html(page + 1).val(page + 1).hide() : $('ul li a[name="getPage06"]').html(page + 1).val(page + 1).show();
				(res['house']['last_page'] - 2 < page) ? $('ul li a[name="getPage07"]').html(page + 2).val(page + 2).hide() : $('ul li a[name="getPage07"]').html(page + 2).val(page + 2).show();
				(res['house']['last_page'] - 1 < page) ? $('ul li a[name="getPage08"]').val(page + 1).hide() : $('ul li a[name="getPage08"]').val(page + 1).show();
				$('ul li a[name="getPage09"]').html(`共` + res['house']['last_page'] + `頁`).val(res['house']['last_page']).show();

				// 刷新分頁欄位
				label += `<ul class="pagination">`
				label += `<div><a href="#" id="getPage" onClick="getManage(1)" >1</a></div>`;
				if (page > 1) label += `<li><a href="#" id="getPage" onClick="getManage(${page - 1})" >&laquo;</a></li>`;
				if (page > 2) label += `<li><a href="#" id="getPage" onClick="getManage(${page - 2})" >${page - 2}</a></li>`;
				if (page > 1) label += `<li><a href="#" id="getPage" onClick="getManage(${page - 1})" >${page - 1}</a></li>`;
				label += `<li><a href="#" id="getPage" onClick="getManage(${page})" >${page}</a></li>`;
				if (res['house']['last_page'] - 1 >= page) label += `<li><a href="#" id="getPage" onClick="getManage(${page + 1})" >${page + 1}</a></li>`;
				if (res['house']['last_page'] - 2 >= page) label += `<li><a href="#" id="getPage" onClick="getManage(${page + 2})" >${page + 2}</a></li>`;
				if (res['house']['last_page'] - 1 >= page) label += `<li><a href="#" id="getPage" onClick="getManage(${page + 1})" >&raquo;</a></li>`;
				label += `<div><a href="#" id="getPage" onClick="getManage(${res['house']['last_page']})" >${res['house']['last_page']}</a></div>`;
				label += `</ul>`;
				$.each(res['house'].data, function (key, val) {
					// $.each(val.photo_list, function (key2, val2) {
					// 	imgStr += `<div class="col-1">
					// 			<img src="${val2}" class="img-thumbnail" >
					// 		</div>`
					// });
					str += `
						<div class="row">
							<div class="col-1">
								<h3><a href="/modify?id=${val.id}">修改</a></h3>
							</div>
							<div class="col-2">
								<h3>${val.id}</h3>
							</div>
							<div class="col-2">
								<h3>${val.title}</h3>
							</div>
							<div class="col-2">
								<h3><label>${val.price}</label></h3>
							</div>
							<div class="col-2">
								<h3>${val.contact} : ${val.role_name}</h3>
							</div>
							<div class="col-1">
								<h3><a href="#" onClick="ajaxDelete(${val.id})">刪除</a></h3>
							</div>
						</div>`;
				})
				$('#postForm').val("回傳成功"); //更改網頁元素
				$('#body01').html(str); //更改網頁元素
				$('#body02').html(label); //更改網頁元素
			} else {
				console.log(res);
				$('#postForm').val("回傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#postForm').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}

function ajaxDelete(id) {
	$.ajax({
		url: '/ajaxDelete', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'id': id, //編號
		},
		success: function (res) { //成功
			if (res) {
				// console.log(res['id']);
				// console.log(res['house']);
				$('#postForm').val("回傳成功"); //更改網頁元素
				if (res['house'] == 1) {
					alert(res['id'] + " 已成功刪除");
					getManage();
				} else if (res['house'] == 0) {
					alert("找不到 " + res['id'] + " 或已被刪除");
				} else {
					alert(res['id'] + " 異常");
				}
			} else {
				console.log(res);
				$('#postForm').val("回傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#postForm').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}

function ajaxModify(id) {
	$.ajax({
		url: '/ajaxModify', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			'id': id, //編號
			'title': $("#標題").val(), //標題
			'price': $("#金額").val(), //金額
			'community': $("#路段").val(), //路段
			'photo_list': $("#圖片").val(), //圖片
			'role_name': $("#身份").val(), //身份
			'contact': $("#聯絡人").val(), //聯絡人
			'floor_str': $("#樓層").val(), //樓層
			'kind_name': $("#類型").val(), //類型
			'room_str': $("#格局").val(), //格局
		},
		success: function (res) { //成功
			if (res) {
				$('#postModify').val("修改成功"); //更改網頁元素
				if (isset(res['id'])) {
					alert(res['id'] + " 修改");
				}
			} else {
				console.log(res);
				$('#postModify').val("修改失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#postModify').val("修改發生錯誤"); //更改網頁元素
			alert("修改發生錯誤");
		}
	});
	return false;
}

function ajaxAddImg() {
	$('#addImg').val("上傳中..."); //更改網頁元素
	var formData = new FormData($('#ajaxAddImg')[0]);
	// var formData = new FormData();
	// formData.append($('myfile', '#myfile'));
	// var formData = new FormData();
	// formData.append("accountnum", 123456); //数字123456会被立即转换成字符串 "123456"
	// var content = '<a id="a"><b id="b">hey!</b></a>'; // 新文件的正文
	// var blob = new Blob([content], { type: "text/xml"});
	// formData.append("webmasterfile", blob);
	$.ajax({
		url: '/ajaxAddImg', //傳送頁面
		type: 'POST', //傳送方式
		data: formData, //圖片
		cache: false,	//避免有圖片 cache 狀況。
		processData: false,	//不用額外處理資料。例：如果是 GET，預設會將 data 物件資料字串化，放到網址。
		contentType: false,	//若有傳送檔案，設定 false，也就是會將 header 資訊中的 Content-Type 設定成 multipart/form-data；預設是 application/x-www-form-urlencoded。
		success: function (res) { //成功
			if (res) {
				// $("#addImgShow").css('display', 'none');	//隱藏元素
				$('#addImg').val(res.message); //更改網頁元素
			} else {
				console.log(res);
				$('#addImg').val("上傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#addImg').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}

function ajaxAdd() {
	$('#ajaxAddButton').val("上傳中..."); //更改網頁元素
	$.ajax({
		url: '/ajaxAdd', //傳送頁面
		type: 'POST', //傳送方式
		data: {
			// 'id': id, //編號
			'title': $("#titleAdd").val(), //標題
			'price': $("#priceAdd").val(), //金額
			'community': $("#communityAdd").val(), //路段
			'photo_list': ['test'], //圖片
			'role_name': $("#role_nameAdd").val(), //身份
			'contact': $("#contactAdd").val(), //聯絡人
			'floor_str': $("#floor_strAdd").val(), //樓層
			'kind_name': $("#kind_nameAdd").val(), //類型
			'room_str': $("#room_strAdd").val(), //格局
		},
		// cache: false,	//避免有圖片 cache 狀況。
		// processData: false,	//不用額外處理資料。例：如果是 GET，預設會將 data 物件資料字串化，放到網址。
		// contentType: false,	//若有傳送檔案，設定 false，也就是會將 header 資訊中的 Content-Type 設定成 multipart/form-data；預設是 application/x-www-form-urlencoded。
		success: function (res) { //成功
			if (res) {
				$('#ajaxAddButton').val("上傳成功"); //更改網頁元素
			} else {
				console.log(res);
				$('#ajaxAddButton').val("上傳失敗"); //更改網頁元素
			}
		},
		error: function () { //失敗
			$('#ajaxAddButton').val("發生錯誤"); //更改網頁元素
			alert("發生錯誤");
		}
	});
	return false;
}

function isset(issetValue) {	// PHP JS上的JavaScript isset()
	var a = arguments,
		l = a.length,
		i = 0,
		undef;

	if (issetValue === 0) {
		throw new Error('Empty isset');
	}

	while (issetValue !== l) {
		if (a[i] === undef || a[i] === null) {
			return false;
		}
		i++;
	}
	return true;
}


$("#myfile").change(function () {
	readURL(this); // this代表<input id="">
});

function readURL(input) {	// 顯示上傳圖片
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$("#addImgShow").attr('src', e.target.result);
			$("#addImgShow").css('display', 'block');
		}
		reader.readAsDataURL(input.files[0]);
	}
}