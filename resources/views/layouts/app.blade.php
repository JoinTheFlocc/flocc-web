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
	<footer class="navbar-default navbar-static-bottom grad">
		@include('layouts.footer')
	</footer>

	<script type="text/javascript">
  (function(e,t,n,r){function i(e,n){e=t.createElement("script");e.async=1;e.src=r;n=t.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)}e[n]=e[n]||function(){(e[n].q=e[n].q||[]).push(arguments)};e.attachEvent?e.attachEvent("onload",i):e.addEventListener("load",i,false)})(window,document,"_castle","//d2t77mnxyo7adj.cloudfront.net/v1/c.js")
  _castle('setAppId', '988356266816382');
</script>
<script type="text/javascript">
  (function(e,t,n,r){function i(e,n){e=t.createElement("script");e.async=1;e.src=r;n=t.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)}e[n]=e[n]||function(){(e[n].q=e[n].q||[]).push(arguments)};e.attachEvent?e.attachEvent("onload",i):e.addEventListener("load",i,false)})(window,document,"_castle","//d2t77mnxyo7adj.cloudfront.net/v1/c.js")
  _castle('setAppId', '988356266816382');
  _castle('identify', '1234', {  // 1234 is this user's id in your database
    name: 'Jane Doe', // optional
    email: 'jane@doe.io' // optional
  });
</script>
</body>
</html>
