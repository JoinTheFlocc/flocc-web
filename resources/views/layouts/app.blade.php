<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Join the Flocc</title>

	<link href="https://fonts.googleapis.com/css?family=Signika:300,400,600,700" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico:400" rel="stylesheet" type="text/css">

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/css/bootstrap-social.css" rel="stylesheet" type="text/css">
    
	<script src="/js/jquery-2.1.4.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>

	<link href="/css/flocc.css" rel="stylesheet" type="text/css">
 </head>

<body>
	<div class="container">
		<nav class="navbar navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
                    <a class="navbar-brand" href="/"><i class="fa fa-btn fa-group"></i> Flocc<small> alpha</small></a>
				</div>
				<div id="navbar">
					<ul class="nav navbar-nav navbar-right">
				    @if (Auth::guest())
						<li>
                            <a href="{{ URL::route('auth.register') }}"><i class="fa fa-btn fa-heart"></i>Register</a>
                        </li>
                        <li>
                            <a href="{{ URL::route('auth.login') }}"><i class="fa fa-btn fa-sign-in"></i>Login</a>
                        </li>
				    @else
                        <li>
                            <a href="{{ url('/profile/' . Auth::user()->profile->id) }}"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</a>
                        </li>
							<li><a href="{{ URL::route('mail') }}"><i class="fa fa-btn fa-envelope"></i>Mail</a></li>
							<li>
								<a href="{{ URL::route('notifications') }}">
									<i class="fa fa-btn fa-bell"></i> Notifications <span class="label label-danger" id="notificationsCount" style="display:none">0</span>
								</a>
							</li>
				        <li>
                            <a href="{{ URL::route('auth.logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                        </li>
				    @endif
					</ul>
				</div>
			</div>
		</nav>
	</div>

	@yield('content')

	@include('layouts.footer')
</body>
</html>
