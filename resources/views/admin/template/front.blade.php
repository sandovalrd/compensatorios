<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Default') | Siscomp</title>
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
	<div class="container">
		<section>
			@include('admin.template.nav')
		</section>
		<section>
			@yield('content')
		</section>
		<section>
			
		</section>
	</div>
		

	<script src="{{ asset ('plugins/jquery/js/jquery-3.2.1.js') }}"></script>
	<script src="{{ asset ('plugins/bootstrap/js/bootstrap.js') }}"></script>
</body>
</html>