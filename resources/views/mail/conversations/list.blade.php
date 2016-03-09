@extends('layouts.wsidebar')

@section('sidebar')
    @include('layouts._partials.social')
@endsection

@section('content')
    <div class="contentBox">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Messages: {{ $label }}</h4>
            </div>
            <div class="panel-body">
                <!-- Display flash messages -->
                @include('common.errors')
                @if (isset($message))
                    <div class="flash-message">
                        <p class="alert alert-success">{{ $message }}</p>
                    </div>
                @endif
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th class="text-center">Unread messages</th>
                            <th class="text-center">Last message date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($conversations as $conversation)
                            <tr class="@if($conversation->is_important == '1') important @endif">
                                <td class="text-center">
                                    @if($conversation->is_important == '1')
                                        <i class="fa fa-exclamation-circle"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::route('mail.conversation', ['id' => $conversation->conversation_id]) }}">
                                        Conversation with {{ $conversation->users_list }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $conversation->unread_messages }}</td>
                                <td class="text-center">{{ $conversation->last_message_time }}</td>
                            </tr>
                        @empty
                            <strong>You don't have any messages!</strong>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <a href="{{ URL::route('mail.label', ['label' => 'trash']) }}" class="btn btn-danger">
                    Trash
                </a>
            </div>
        </div>
    </div>
@endsection
