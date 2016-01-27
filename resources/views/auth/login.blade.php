@extends('layouts.app')

@section('content')
<div class="container-fluid mainBox">
	<div class="loginBox container">
		<div class="col-sm-offset-3 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Log in</h4>
				</div>

				<div class="panel-body">
					<!-- Display flash messages -->
					@include('common.errors')
                    @if (isset($message))
                    <div class="flash-message">
                        <p class="alert alert-success">{{ $message }}</p>
                    </div>
                    @endif

                    <form id="loginForm" action="/auth/login" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label"><i class="fa fa-btn fa-at"></i></label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="col-sm-2 control-label"><i class="fa fa-btn fa-lock"></i></label>
                            <div class="col-sm-8">
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <!-- Login Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>
                                <p>
                                    <small><a href="{{ url('/password/email') }}">Forgot your password?</a></small>
                                </p>
							</div>
                        </div>
                    </form>
                    @include('auth._partials.social')
				</div>
                <div class="panel-footer text-right">
                    <span>New to Flocc? </span>
                    <a href="/auth/register">Register</a>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
