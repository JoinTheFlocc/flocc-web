@extends('wsidebar.app')

@section('content')
	<div class="contentBox">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Change password</h4>
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
					<div class="form-group">
						{!! Form::label('old_password', 'Old password', ['class' => 'col-sm-2 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('old_password', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<!-- new password -->
					<div class="form-group">
						{!! Form::label('new_password', 'New password', ['class' => 'col-sm-2 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('new_password', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<!-- Password -->
					<div class="form-group">
						{!! Form::label('confirm_password', 'Confirm password', ['class' => 'col-sm-2 control-label']) !!}
						<div class="col-sm-6">
							{!! Form::text('confirm_password', null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<!-- Reset Button -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<button type="submit" class="btn btn-primary pull-right">
								<i class="fa fa-btn fa-refresh"></i>Reset password
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4 class="panel-title">Delete account</h4>
			</div>

			<div class="panel-body">
				<!-- Display flash messages -->
				@include('common.errors')
				@if (isset($message))
				<div class="flash-message">
					<p class="alert alert-success">{{ $message }}</p>
				</div>
				@endif

				<form id="loginForm" action="#" method="POST" class="form-horizontal">
				{{ csrf_field() }}
					<!-- Reset Button -->
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-6">
							<button type="submit" class="btn btn-danger pull-right">
								<i class="fa fa-btn fa-remove"></i>Delete account
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

    @include('profiles._partials.bottomscripts')

@endsection
