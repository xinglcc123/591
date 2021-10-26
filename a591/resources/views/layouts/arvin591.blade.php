<html>

<head>
	<title>Arvin 591租屋</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!-- <meta name="csrf-token" content="{{ csrf_token() }}"> -->
	<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
	<!-- X-CSRF-TOKEN -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

</html>


<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-11">
				<!-- 表單 form -->
				<form action="#" method="post">
					<!-- CSRF 保護 -->
					<!-- {{ csrf_field() }} -->
					<!-- 表格 table -->
					<table class="table">
						<thead class="thead-light">
							<tr>
								<th scope="col-1">Arvin 591租屋</th>
							</tr>
						</thead>
						<tr>
							<th>搜尋：</th>
							<td class="td_right"><input type="text" name="title" id="title" placeholder="關鍵字" value=""></td>
						</tr>
						<tr scope="row">
							<th scope="col-1">金額：</th>
							<td><input type="checkbox" name="price" id="price" value="0,5000">0~5000</td>
							<td><input type="checkbox" name="price" id="price" value="5000,10000">5000~10000</td>
							<td><input type="checkbox" name="price" id="price" value="10000,15000">10000~15000</td>
							<td><input type="checkbox" name="price" id="price" value="15000,20000">15000~20000</td>
							<td>最低金額：<input type="text" name="priceMin" id="priceMin" placeholder="金額" value=""></td>
							<td>最大金額：<input type="text" name="priceMax" id="priceMax" placeholder="金額" value=""></td>
							<td></td>
						</tr>
						<tr>
							<th>刊登身分</th>
							<td><input type="radio" name="role_name" id="role_name" value="屋主">屋主</td>
							<td><input type="radio" name="role_name" id="role_name" value="代理人">代理人</td>
							<td><input type="radio" name="role_name" id="role_name" value="仲介">仲介</td>
						</tr>
						<tr>
							<th></th>
							<td><input class="btn btn-primary" id="postForm" type="button" value="傳送" onClick="getMessage()" /></td>
						</tr>
						</tbody>
					</table>
				</form>
			</div>

			<div class="col-xl-1">
				<div style="text-align:right;" valign="top">
					<h1><a href="/login">登入</a></h1>
				</div>
			</div>
		</div>
	</div>
	@yield('body03')
	@yield('body02')
	@yield('body01')
	@yield('body03')
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/index.js"></script>