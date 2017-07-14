<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Default') | Siscomp</title>
	<link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/chosen/chosen.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datetimepicker/css/bootstrap-datetimepicker.css') }}">

</head>
<body>
	<div class="container">
		<section>
			@include('admin.template.nav')
		</section>
		<section>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="text-info">@yield('sub-title')</h4>
				</div>
				<div class="panel-body">
					<br>
					<div class="col-md-offset-2 col-md-8">
						@include('flash::message')
						<br>
					</div>
					@include('admin.template.error')
					@yield('content')
				</div>
			</div>
		</section>
		<section>
			
		</section>
	</div>
	<script src="{{ asset ('plugins/jquery/js/jquery-2.1.1.min.js') }}"></script>
	<script src="{{ asset ('plugins/bootstrap/js/bootstrap.js') }}"></script>
	<script src="{{ asset ('plugins/chosen/chosen.jquery.js') }}"></script>
	<script src="{{ asset ('plugins/datetimepicker/js/moment-with-locales.js') }}"></script>
	<script src="{{ asset ('plugins/datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
	@yield('script')
</body>
</html>


  
  