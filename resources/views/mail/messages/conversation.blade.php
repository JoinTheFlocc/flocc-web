@extends('layouts.app')

@section('content')
    <div class="contentBox">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <ul>
                                @foreach ($conversation->messages as $message)
                                    <li>
                                        <p>{{ $message->message }}</p>
                                        {{ $message->sent_date }} by <a href="{{ URL::route('profile.display', ['id' => $message->user_id]) }}">{{ $message->name }}</a>
                                    </li>
                                @endforeach
                            </ul><br>

                            <h2>Send new message</h2><br>
                            <form method="POST" action="{{ URL::route('mail.new') }}">
                                <textarea name="message" class="form-control" rows="3" placeholder="Message here" required="required"></textarea><br>
                                <input type="hidden" name="conversation_id" value="{{ $conversation->conversation_id }}">
                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <strong>Start at:</strong><br>
                            <p>{{ $conversation->start_time }}</p>
                            <hr>
                            <strong>Members ({{ count($conversation->users) }}):</strong><br>
                            <ul>
                                @foreach ($conversation->users as $user)
                                    <li>
                                        <a href="{{ URL::route('profile.display', ['id' => $user->id]) }}">
                                            {{ $user->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <br>
                            <a href="{{ URL::route('mail.move', ['id' => $conversation->conversation_id, 'label' => 'trash']) }}" class="btn btn-danger">
                                Move to trash
                            </a>
                            @if($conversation->isImportant() === false)
                                <a href="{{ URL::route('mail.important', ['id' => $conversation->conversation_id, 'is' => '1']) }}" class="btn btn-default">
                                    Oznacz jako ważna
                                </a>
                            @else
                                <a href="{{ URL::route('mail.important', ['id' => $conversation->conversation_id, 'is' => '0']) }}" class="btn btn-danger">
                                    Oznacz jako nie ważna
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
