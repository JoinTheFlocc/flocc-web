@extends('layouts.app')

@section('content')
<div class="container-fluid mainBox">
	<div class="loginBox container">
		<div class="col-sm-offset-3 col-sm-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Password reset</h4>
				</div>

				<div class="panel-body">
					<!-- Display flash messages -->
					@include('common.errors')
                    @if (isset($status))
                    <div class="flash-message">
                        <p class="alert alert-success">{{ $status }}</p>
                    </div>
                    @endif

                    <form id="passwordForm" action="/password/email" method="POST" class="form-horizontal">
                    {{ csrf_field() }}
                        <!-- E-Mail Address -->
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label"><i class="fa fa-btn fa-at"></i></label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <!-- Send Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-send"></i>Send Password Reset Link
                                </button>
							</div>
                        </div>
                    </form>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
