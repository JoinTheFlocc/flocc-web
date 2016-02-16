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

	<link href="/css/flocc.css" rel="stylesheet" type="text/css">

	@if(isset($meta_facebook))
		<meta property="og:url"           content="{{ $meta_facebook->getUrl() }}" />
		<meta property="og:type"          content="{{ $meta_facebook->getType() }}" />
		<meta property="og:title"         content="{{ $meta_facebook->getTitle() }}" />
		<meta property="og:description"   content="{{ $meta_facebook->getDescription() }}" />
		<meta property="og:image"         content="{{ $meta_facebook->getImage() }}" />
	@endif
 </head>

<body>
	@include('layouts.navbar')
	<section id="main">
		<div class="container mainBoxA">
			<div class="row">
				<div class="col-md-3">
					<div class="contentBox">
						<div class="panel panel-default panel-sidebar">
							<div class="panel-heading">
								<h4 class="panel-title">Settings</h4>
							</div>
							<div class="panel-body">
								<div class="list-group settings">
									<a href="{{ URL::route('profile.edit', $profile->id) }}" class="list-group-item">Profile</a>
									<a href="{{ URL::route('settings.account') }}" class="list-group-item">Account settings</a>
									<a href="{{ URL::route('settings.notifications') }}" class="list-group-item">Notification center</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					@yield('content')
				</div>
			</div>
		</div>
	</section>
	<footer class="navbar-default navbar-static-bottom">
		@include('layouts.footer')
	</footer>
</body>
</html>
