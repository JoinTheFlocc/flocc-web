@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            <h1>Wydarzenia</h1><br>

            <a href="{{ URL::route('events.new') }}" class="btn btn-success">
                Utwórz nowe wydarzenie
            </a><br>&nbsp;<br>

            @if($events->count() > 0)
                <ul class="events">
                    @foreach($events as $event)
                        <li>
                            <h2>
                                <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                                    {{ $event->getTitle() }}
                                </a>
                            </h2>
                            <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                                <img src="{{ $event->getAvatarUrl() }}">
                            </a>

                            <div class="buttons">
                                @if($user_id == $event->getUserId())
                                    <!-- Moje wydarzenie -->
                                    <a href="#"><i class="fa fa-users"></i></a>
                                    <a href="#"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="close_event"><i class="fa fa-times"></i></a>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>

                {!! $events->render() !!}
            @else
                <div class="alert alert-info">
                    Brak wydarzeń pasujących do podanych kryteriów
                </div>
            @endif
        </div>
    </div>
@endsection