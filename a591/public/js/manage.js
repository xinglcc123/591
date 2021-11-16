getManage();

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
	console.log($('form').serialize());
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
								<h3><a href="#" onClick="modify(${val.id})">修改</a></h3>
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
				console.log(res['id']);
				console.log(res['house']);
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

function modify(id) {
	$.ajax({
		url: '/modify', //傳送頁面
		type: 'GET', //傳送方式
		data: {
			'id': id, //編號
		},
		success: function (res) { //成功
			if (res) {
				alert(res['id'] + " 回傳成功");
				$('#postForm').val("回傳成功"); //更改網頁元素
				if (isset(res['id'])) {
					window.location.href = '/modify?id=' + res['id'];
					alert(res['id'] + " 修改");
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
		},
		success: function (res) { //成功
			if (res) {
				$('#postForm').val("回傳成功"); //更改網頁元素
				if (isset(res['id'])) {
					alert(res['id'] + " 修改");
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

function isset (issetValue) {
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