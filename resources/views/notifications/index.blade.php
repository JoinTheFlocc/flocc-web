@extends('layouts.app')

@section('content')
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Notifications
                </div>
                <div class="panel-body">
                    @if(count($data) > 0)
                        @foreach($data as $row)
                            <div>
                                <a href="{{ URL::route('notifications.callback', ['id' => $row->notification_id]) }}" style="display:block;border:1px dotted #000;padding:10px;">
                                    {{ $row->name }}
                                    <span class="pull-right">{{ $row->sent_time }}</span>
                                </a>
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
