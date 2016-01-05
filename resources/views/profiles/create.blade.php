@extends('layouts.app')

@section('content')
	<div class="container contentBox">
        <div class="col-sm-offset-1 col-sm-3">
            <div id="avcarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/img/avatar.png" alt="" class="avatar img-thumbnail">
                        <div class="carousel-caption">
                            <button type="submit" class="btn btn-sm btn-primary">
								<i class="fa fa-btn fa-upload"></i>Click to change
				            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--
            <img src="/img/avatar.png" class="avatar img-thumbnail">
            //-->
        </div>
		<div class="col-sm-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Tell us more about yourself, {{ Auth::user()->name }}</h4>
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')
                    
                    {!! Form::open(['route' => 'profile.store', 'class' => 'form-horizontal']) !!}
                        @include('profiles._partials.form', ['submitButton' => 'Create Profile'])
                    {!! Form::close() !!}
					</form>
				</div>
			</div>
		</div>
	</div>

    @include('profiles._partials.bottomscripts')

@endsection