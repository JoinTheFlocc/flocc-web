@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            @if(!Auth::guest())
                <a href="{{ URL::route('events.new.inspiration') }}" class="btn btn-primary pull-right" style="margin-left:10px;">
                    Utwórz nową inspirację
                </a>
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
                                <strong>Co</strong><br>&nbsp;

                                <select name="activity_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->getId() }}" @if(isset($form_data['activity_id']) and $form_data['activity_id'] == $activity->getId()) selected="selected" @endif>{{ $activity->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Gdzie</strong><br>&nbsp;

                                <input type="text" name="place" class="form-control place_auto_complete" @if(isset($form_data['place'])) value="{{ $form_data['place'] }}" @endif autocomplete="off">
                            </div>

                            <div class="well">
                                <strong>Jak</strong><br>&nbsp;

                                <select name="tribe_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($tribes as $tribe)
                                        <option value="{{ $tribe->getId() }}" @if(isset($form_data['tribe_id']) and $form_data['tribe_id'] == $tribe->getId()) selected="selected" @endif>{{ $tribe->getName() }}</option>
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
                                    <option value="">Wybierz</option>
                                    <option value="1" @if(isset($form_data['event_span']) and $form_data['event_span'] == '1') selected="selected" @endif>do 2 dni</option>
                                    <option value="2" @if(isset($form_data['event_span']) and $form_data['event_span'] == '2') selected="selected" @endif>3-5 dni</option>
                                    <option value="3" @if(isset($form_data['event_span']) and $form_data['event_span'] == '3') selected="selected" @endif>6-14 dni</option>
                                    <option value="4" @if(isset($form_data['event_span']) and $form_data['event_span'] == '4') selected="selected" @endif>powyżej 14 dni</option>
                                </select>
                            </div>

                            <div class="well">
                                <strong>Budżet</strong><br>&nbsp;

                                <select name="budget_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($budgets as $budget)
                                        <option value="{{ $budget->getId() }}" @if(isset($form_data['budget_id']) and $form_data['budget_id'] == $budget->getId()) selected="selected" @endif>{{ $budget->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Aktywność</strong><br>&nbsp;

                                <select name="intensities_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($intensities as $intensity)
                                        <option value="{{ $intensity->getId() }}" @if(isset($form_data['intensities_id']) and $form_data['intensities_id'] == $intensity->getId()) selected="selected" @endif>{{ $intensity->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Sposób podróżowania</strong><br>&nbsp;

                                <select name="travel_ways_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($travel_ways as $travel_way)
                                        <option value="{{ $travel_way->getId() }}" @if(isset($form_data['travel_ways_id']) and $form_data['travel_ways_id'] == $travel_way->getId()) selected="selected" @endif>{{ $travel_way->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Infrastruktura</strong><br>&nbsp;

                                <select name="infrastructure_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($infrastructure as $infrastructure_row)
                                        <option value="{{ $infrastructure_row->getId() }}" @if(isset($form_data['infrastructure_id']) and $form_data['infrastructure_id'] == $infrastructure_row->getId()) selected="selected" @endif>{{ $infrastructure_row->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Turystyczność</strong><br>&nbsp;

                                <select name="tourist_id" class="form-control">
                                    <option value="">Wybierz</option>
                                    @foreach($tourist as $tourist_row)
                                        <option value="{{ $tourist_row->getId() }}" @if(isset($form_data['tourist_id']) and $form_data['tourist_id'] == $tourist_row->getId()) selected="selected" @endif>{{ $tourist_row->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="well">
                                <strong>Turystyczność</strong><br>&nbsp;<br>

                                <label>
                                    <input type="checkbox" name="voluntary" value="1" @if(isset($form_data['voluntary']) and $form_data['voluntary'] == '1') checked="checked" @endif> Wolontariat
                                </label><br>
                                <label>
                                    <input type="checkbox" name="language_learning" value="1" @if(isset($form_data['language_learning']) and $form_data['language_learning'] == '1') checked="checked" @endif> Nauka języków
                                </label>
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
                                <li style="@if($event->isMine()) border:1px solid red; @endif">
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

                                            @if($event->isInspiration())
                                                Miesiąc: <strong>{{ $event->getEventMonthName() }}</strong> |
                                            @else
                                                Data: <strong>{{ $event->getEventFrom() }}-{{ $event->getEventTo() }} ({{ $event->getEventSpan() }} dni)</strong> |
                                            @endif

                                            @if($event->isPlace())
                                                Miejsce: <strong>{{ $event->getPlace()->getName() }}</strong>
                                            @else
                                                Miejsce: <strong>@foreach($event->getRoutes() as $place) {{ $place->getName() }} > @endforeach</strong>
                                            @endif
                                             | Punkty: {{ $event->scoring }}
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
