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
			<div class="col-xl-2">
				<div style="text-align:right;" valign="top">
					<h1><a href="/forgot-password">忘記密碼</a></h1>
				</div>
			</div>
			<div class="col-xl-2">
				<div style="text-align:right;" valign="top">
					<h1><a href="/login">登入頁面</a></h1>
				</div>
			</div>
			<div class="col-xl-2">
				<div style="text-align:right;" valign="top">
					<h1><a href="/register">註冊頁面</a></h1>
				</div>
			</div>
		</div>
	</div>
	@yield('index01')
	@yield('body03')
	@yield('body01')
	@yield('body03')
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="js/index.js"></script>