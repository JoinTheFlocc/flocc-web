@extends('layouts.app')

@section('content')
	<div class="loginBox container">
		<div class="col-sm-offset-3 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Register</h4>
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')
                                        
                    <form id="registerForm" action="/auth/register" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <!-- Username -->
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label"><i class="fa fa-btn fa-user"></i></label>
                            <div class="col-sm-8">
                                <input type="name" name=" name" class="form-control" placeholder="Name">
                            </div>
                        </div>             
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
                        <!-- Confirm Password -->
                        <!--
                        <div class="form-group">
				            <label for="password_confirmation" class="col-sm-2 control-label"><i class="fa fa-btn fa-lock"></i></label>
				            <div class="col-sm-8">
				                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
				            </div>
				        </div>
                        //-->
                        <!-- Register Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-sign-in"></i>Register
                                </button>
                            </div>
                        </div>    
                    </form>
                    @include('auth._partials.social')
				</div>
                <div class="panel-footer text-right">
                    <span>Already have an account? </span>
                    <a href="/auth/login">Log in</a>
                </div>
			</div>
		</div>
	</div>
@endsection