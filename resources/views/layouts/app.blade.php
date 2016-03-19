<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex">

	<title>Join the Flocc</title>

	<link href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&subset=latin,latin-ext" rel="stylesheet" type="text/css">
 	<link href="https://fonts.googleapis.com/css?family=Pacifico:400" rel="stylesheet" type="text/css">
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-social.css" rel="stylesheet" type="text/css">
	<link href="/css/flocc.css" rel="stylesheet" type="text/css">

	<script>
		window.fbAsyncInit = function() {
    	  FB.init({
      		appId      : '178041392343208',
      		xfbml      : true,
      		version    : 'v2.5'
    	  });
  		};

  		(function(d, s, id){
     	  var js, fjs = d.getElementsByTagName(s)[0];
     	  if (d.getElementById(id)) {return;}
     	  js = d.createElement(s); js.id = id;
     	  js.src = "//connect.facebook.net/en_US/sdk.js";
     	  fjs.parentNode.insertBefore(js, fjs);
   		}(document, 'script', 'facebook-jssdk'));
	</script>

	<script src="/js/jquery-2.2.0.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>

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

	@yield('content')

	<footer class="navbar-default navbar-static-bottom grad">
		@include('layouts.footer')
	</footer>

	@yield('bottomscripts')

	<!-- castle.io friendly testing -->
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
