@extends('layouts.wsidebar')

@section('content')
	<div class="contentBox">
    	<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">Edit profile</h4>
			</div>
			<div class="panel-body">
				<!-- Display flash messages -->
				@include('common.errors')
                @if (isset($message))
                    <div class="flash-message">
                        <p class="alert alert-success">{{ $message }}</p>
                    </div>
                @endif
				<div class="col-sm-3">
					<a href="#" onclick="openImageModal();" title="imageModal" data-toggle="modal" datat-target="#imageModal">
						<img src="{{ $profile->avatar_url or '/img/avatar.png' }}" alt="" class="avatar img-thumbnail">
	                    <span class="pull-right">Click to change</span>
	                </a>
	            </div>
				<div class="col-sm-9">
                {!! Form::model($profile, ['method' => 'PATCH', 'route' => ['profile.update', $profile->id], 'class' => 'form-horizontal']) !!}
					@include('profiles._partials.form', ['submitButton' => 'Update'])
				{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
    @include('profiles._partials.avatarForm')
    @include('profiles._partials.bottomscripts')

@endsection
