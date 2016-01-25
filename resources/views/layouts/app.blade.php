<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Join the Flocc</title>

	<link href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
 	<link href="https://fonts.googleapis.com/css?family=Pacifico:400" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-social.css" rel="stylesheet" type="text/css">
	<link href="/css/flocc.css" rel="stylesheet" type="text/css">

	<script src="/js/jquery-2.2.0.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</head>

<body>
	@include('layouts.navbar')
	@if (isset($sidebarView))
	<section id="main">
		<div class="container mainBoxA">
			<div class="row">
				<div class="col-md-3">
					@include('layouts.sidebar')
				</div>
				<div class="col-md-9">
					@yield('content')
				</div>
			</div>
		</div>
	</section>
	@else
		@yield('content')
	@endif
	<footer class="navbar-default navbar-static-bottom">
		@include('layouts.footer')
	</footer>
</body>
</html>
