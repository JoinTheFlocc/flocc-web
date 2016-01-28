<nav class="navbar navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/img/logo_min.png" class="img-responsive" style="inline: block">
            </a>
            <div class="navbar-text">
                Flocc <small>alpha</small>
            </div>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ URL::route('events') }}"><i class="fa fa-globe"></i> Wydarzenia</a></li>

                @if (Auth::guest())
                    <li>
                      <a href="{{ URL::route('auth.register') }}"><i class="fa fa-btn fa-heart"></i>Register</a>
                    </li>
                    <li>
                      <a href="{{ URL::route('auth.login') }}"><i class="fa fa-btn fa-sign-in"></i>Login</a>
                    </li>
                @else
                      @if(Auth::user()->profile)
                        <li>
                          <a href="{{ url('/profile/' . Auth::user()->profile->id) }}"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</a>
                        </li>
                      @endif
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
