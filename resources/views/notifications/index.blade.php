@extends('layouts.wsidebar')

@section('sidebar')
    @include('layouts._partials.social')
@endsection

@section('content')
<div class="contentBox">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">Notifications</h4>
        </div>
        <div class="panel-body">
            <!-- Display flash messages -->
            @include('common.errors')
            @if (isset($message))
                <div class="flash-message">
                    <p class="alert alert-success">{{ $message }}</p>
                </div>
            @endif
            @if(count($data) > 0)
                @foreach($data as $row)
                    <div class="row" @if($row->is_read == '0') style="background: #ffa3a7" @endif>
                        <div class="col-md-11">
                            <a href="{{ URL::route('notifications.callback', ['id' => $row->notification_id]) }}" style="display:block;border:1px dotted #000;padding:10px;">
                                {{ $row->name }}
                                <span class="pull-right">{{ $row->sent_time }}</span>
                            </a>
                        </div>
                        <div class="col-md-1" style="padding-top: 5px;px;">
                            <a href="{{ URL::route('notifications.delete', ['id' => $row->notification_id]) }}" class="btn btn-danger">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger">
                    Empty list
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
