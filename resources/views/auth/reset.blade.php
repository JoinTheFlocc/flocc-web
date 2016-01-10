@extends('layouts.app')

@section('content')
	<div class="loginBox container">
		<div class="col-sm-offset-3 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Password reset</h4>
				</div>

				<div class="panel-body">
					<!-- Display flash messages -->
					@include('common.errors')
                    @if (isset($message))
                    <div class="flash-message">
                        <p class="alert alert-success">{{ $message }}</p>
                    </div>
                    @endif
                    
                    <form id="loginForm" action="/password/reset" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
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
                        <!-- Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="col-sm-2 control-label"><i class="fa fa-btn fa-lock"></i></label>
                            <div class="col-sm-8">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <!-- Reset Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-refresh"></i>Reset password
                                </button>
							</div>
                        </div>
                    </form>
                </div>
			</div>
		</div>
	</div>
@endsection