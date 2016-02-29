@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            @if(!Auth::guest())
                <a href="{{ URL::route('events.new') }}" class="btn btn-success pull-right">
                    Utwórz nowe wydarzenie
                </a><br>&nbsp;<br>
            @endif

            <div class="row">
                @if($search_form)
                <div class="col-md-4">
                    <h2>Wyszukaj</h2><br>

                    <form class="form-horizontal" method="post">
                        <div class="form-group">
                            <div class="well">
                                <strong>Aktywność</strong><br>&nbsp;

                                <select name="activity_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->getId() }}" @if(isset($form_data['activity_id']) and $form_data['activity_id'] == $activity->getId()) selected="selected" @endif>{{ $activity->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="well">
                                <strong>Gdzie</strong><br>&nbsp;

                                <select name="place_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($places as $place)
                                        <option value="{{ $place->getId() }}" @if(isset($form_data['place_id']) and $form_data['place_id'] == $place->getId()) selected="selected" @endif>{{ $place->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="well">
                                <strong>Kiedy</strong><br>&nbsp;

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input name="event_from" class="form-control" placeholder="Od" @if(isset($form_data['event_from'])) value="{{ $form_data['event_from'] }}" @endif>
                                    </div>
                                    <div class="col-sm-6">
                                        <input name="event_to" class="form-control" placeholder="Do" @if(isset($form_data['event_to'])) value="{{ $form_data['event_to'] }}" @endif>
                                    </div>
                                </div>

                                <br>&nbsp;<br>

                                <strong>Ilość dni</strong><br>&nbsp;
                                <select name="event_span" class="form-control">
                                    <option>Wybierz</option>
                                    <option value="1" @if(isset($form_data['event_span']) and $form_data['event_span'] == '1') selected="selected" @endif>do 2 dni</option>
                                    <option value="2" @if(isset($form_data['event_span']) and $form_data['event_span'] == '2') selected="selected" @endif>2-5 dni</option>
                                    <option value="3" @if(isset($form_data['event_span']) and $form_data['event_span'] == '3') selected="selected" @endif>6-14 dni</option>
                                    <option value="4" @if(isset($form_data['event_span']) and $form_data['event_span'] == '4') selected="selected" @endif>powyżej 14 dni</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center">
                            {{ csrf_field() }}
                            <button class="btn btn-success btn-lg">Szukaj</button>
                        </div>
                    </form>
                </div>
                @endif

                <div class="@if($search_form) col-md-8 @else col-md-12 @endif">
                    <h2>Wyniki</h2><br>
                    @if($events->count() > 0)
                        <ul class="events">
                            @foreach($events as $event)
                                <li>
                                    <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                                        <img src="{{ $event->getAvatarUrl() }}">
                                    </a>

                                    <div class="info">
                                        <h2>
                                            <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                                                {{ $event->getTitle() }}
                                            </a>
                                            @if($event->getMember() !== null)
                                                @if($event->getMember()->isStatusAwaiting())
                                                    <span class="label label-danger">
                                                W oczekiwaniu na akceptacje
                                            </span>
                                                @endif
                                            @endif
                                        </h2>

                                        <p>{{ $event->getDescription() }}</p>

                                        <div class="well">
                                            Członków: <strong>{{ $event->getMembers()->count() }}</strong> |
                                            Obserwujących: <strong>{{ $event->getFollowers()->count() }}</strong> |
                                            Data: <strong>{{ $event->getEventFrom() }}-{{ $event->getEventTo() }} ({{ $event->getEventSpan() }} dni)</strong> |
                                            @if($event->isPlace())
                                                Miejsce: <strong>{{ $event->getPlace()->getName() }}</strong>
                                            @else
                                                Miejsce: <strong>@foreach($event->getRoutes() as $place) {{ $place->getName() }} > @endforeach</strong>
                                            @endif
                                        </div>

                                        <div class="buttons">
                                            @if($event->isMine())
                                                    <!-- Moje wydarzenie -->
                                            <a href="{{ URL::route('events.edit.members', ['id' => $event->getId()]) }}"><i class="fa fa-users"></i></a>
                                            <a href="{{ URL::route('events.edit', ['id' => $event->getId()]) }}"><i class="fa fa-pencil"></i></a>
                                            <a href="{{ URL::route('events.event.cancel', ['slug' => $event->getSlug()]) }}" class="close_event"><i class="fa fa-times"></i></a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
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
        </div>
    </div>
@endsection
