@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $label }}
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>&nbsp;</th>
                                <th class="text-center">Unread messages</th>
                                <th class="text-center">Last message date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($conversations as $conversation)
                                <tr>
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
    </div>
@endsection
