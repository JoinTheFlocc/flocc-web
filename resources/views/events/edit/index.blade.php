@extends('layouts.app')

@section('content')
    <div id="event.edit" class="container">
        <div class="row" style="margin:100px 0;">
            <h1 style="text-align: center;">Edycja wydarzenia</h1>

            @if (count($errors) > 0)
                <div class="alert alert-danger" style="margin-top:50px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" method="post" enctype="multipart/form-data" style="margin:50px 0;">
                {{ csrf_field() }}

                <div class="flocc-tabs">

                    <!-- tab 1 -->
                    <div class="flocc-tab" tab-id="tab1">
                        <!-- title -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Tytuł wydarzenia</label>
                            <div class="col-sm-9">
                                <input name="title" class="form-control" value="{{ $event->getTitle() }}">
                            </div>
                        </div>

                        <!-- description -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Opis wydarzenia</label>
                            <div class="col-sm-9">
                                <textarea name="description" class="form-control" rows="4">{{ $event->getDescription() }}</textarea>
                            </div>
                        </div>

                        <!-- dates -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Termin</label>
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class='input-group date' id='datetimepicker6'>
                                            <input name="event_from" type="text" class="form-control" placeholder="Data od" value="{{ $event->getEventFrom() }}">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class='input-group date' id='datetimepicker6'>
                                            <input name="event_to" type="text" class="form-control" placeholder="Data do" value="{{ $event->getEventTo() }}">
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- event_span -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Ilość dni</label>
                            <div class="col-sm-9">
                                <input type="number" name="event_span" class="form-control" value="{{ $event->getEventSpan() }}" style="width:70px;">
                            </div>
                        </div>

                        <div style="margin-top: 50px;text-align:center;">
                            <button class="btn btn-primary btn-lg tab-action change-tab" action-tab-id="tab2">Dalej</button>
                        </div>
                    </div>
                    <!-- tab 1 -->

                    <!-- tab 2 -->
                    <div class="flocc-tab" tab-id="tab2">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="place_type" name="place_type" value="place" @if($event->isPlace()) checked="checked" @endif>
                                            Miejsce wydarzenia
                                        </label>
                                    </div>
                                    <p class="help-block">Wybierz miejsce, w którym odbędzie się to wydarzenia</p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" class="place_type" name="place_type" value="route" @if(!$event->isPlace() and !$event->isStatusDraft()) checked="checked" @endif>
                                            Trasa
                                        </label>
                                    </div>
                                    <p class="help-block">Wybierz trasę miejsc, które obejmuje to wydarzenie</p>
                                </div>
                            </div>
                        </div>

                        <div id="placePlace" class="form-group" style="display:none;">
                            <div class="row">
                                <h2>Miejsce wydarzenia</h2>

                                <select name="place_id" class="form-control" style="margin-top: 50px;">
                                    <option value="0">Wybierz miejsce</option>
                                    @foreach($places as $place)
                                        <option value="{{ $place->getId() }}" @if($event->getPlaceId() == $place->getId()) selected="selected" @endif>{{ $place->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="placeRoute" class="form-group" style="display:none;">
                            <div class="row">
                                <h2>Trasa</h2>

                                <ul id="places_route"></ul>
                                <input type="hidden" name="route" id="route">

                                <div class="add_place">
                                    <select id="placesList" class="form-control pull-left" style="width:95%;">
                                        <option value="0">Wybierz miejsce</option>
                                        @foreach($places as $place)
                                            <option value="{{ $place->getId() }}">{{ $place->getName() }}</option>
                                        @endforeach
                                    </select>
                                    <i id="addPlace" class="fa fa-plus-circle pull-right"></i>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 50px;text-align: center;">
                            <a href="#" class="btn btn-default btn-lg tab-action change-tab" action-tab-id="tab1">Wstecz</a>
                            <a href="#" class="btn btn-primary btn-lg tab-action change-tab" action-tab-id="tab3">Dalej</a>
                        </div>
                    </div>
                    <!-- tab 2 -->

                    <!-- tab 3 -->
                    <div class="flocc-tab" tab-id="tab3">
                        <!-- users_limit -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Limit użytkowników</label>
                            <div class="col-sm-9">
                                <input type="number" name="users_limit" class="form-control" @if($event->getUsersLimit() > 0) value="{{ $event->getUsersLimit() }}" @endif style="width:70px;">
                            </div>
                        </div>

                        <!-- activities -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Aktywność</label>
                            <div class="col-sm-9">
                                @foreach($activities as $activity)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="activities[]" value="{{ $activity->getId() }}" class="activity" @if($event->isActivity($activity->getId()) or isset($post_activities[$activity->getId()])) checked="checked" @endif>
                                            {{ $activity->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                                <div id="newActivity" class="checkbox" @if($post_new_activity !== null) style="display:block!important;" @endif>
                                    <label>
                                        <input type="checkbox" name="activities[]" value="new" style="margin-top: 11px;" @if($post_new_activity !== null) checked="checked" @endif>
                                        <input type="text" class="form-control" id="new_activities" name="new_activities" @if($post_new_activity !== null) value="{{ $post_new_activity }}" @endif>
                                    </label>
                                </div>
                                @if($post_new_activity == null)
                                    <div style="margin-top:15px;">
                                        <a href="#" id="addActivity" class="btn btn-primary">
                                            <i class="fa fa-plus-circle"></i> Dodaj nową aktywność
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- budgets -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Budzet</label>
                            <div class="col-sm-9">
                                @foreach($budgets as $budget)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="budgets" value="{{ $budget->getId() }}" @if($event->getBudgetId() == $budget->getId()) checked="checked" @endif>
                                            {{ $budget->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- intensities -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Intensywność</label>
                            <div class="col-sm-9">
                                @foreach($intensities as $intensity)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="intensities" value="{{ $intensity->getId() }}" @if($event->getIntensitiesId() == $intensity->getId()) checked="checked" @endif>
                                            {{ $intensity->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- fixed -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Typ wydarzenia</label>
                            <div class="col-sm-9">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="fixed" value="1" @if(!$event->isStatusDraft() and $event->isFixed()) checked="checked" @endif>
                                        Odbędzie się
                                    </label>
                                </div>
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="fixed" value="0" @if(!$event->isStatusDraft() and !$event->isFixed()) checked="checked" @endif>
                                        Planowane
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- tribes -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Jak?</label>
                            <div class="col-sm-9">
                                @foreach($tribes as $tribes_row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="tribe_id" value="{{ $tribes_row->getId() }}" @if($event->getTribeId() == $tribes_row->getId()) checked="checked" @endif>
                                            {{ $tribes_row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- travel_ways_id -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sposób podróżowania</label>
                            <div class="col-sm-9">
                                @foreach($travel_ways as $travel_ways_row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="travel_ways_id" value="{{ $travel_ways_row->getId() }}" @if($event->getTravelWaysId() == $travel_ways_row->getId()) checked="checked" @endif>
                                            {{ $travel_ways_row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- infrastructure_id -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Infrastruktura</label>
                            <div class="col-sm-9">
                                @foreach($infrastructure as $infrastructure_row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="infrastructure_id" value="{{ $infrastructure_row->getId() }}" @if($event->getInfrastructureId() == $infrastructure_row->getId()) checked="checked" @endif>
                                            {{ $infrastructure_row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- tourist_id -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Turystyczność</label>
                            <div class="col-sm-9">
                                @foreach($tourist as $tourist_row)
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="tourist_id" value="{{ $tourist_row->getId() }}" @if($event->getTouristId() == $tourist_row->getId()) checked="checked" @endif>
                                            {{ $tourist_row->getName() }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- tourist_id -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">&nbsp;</label>
                            <div class="col-sm-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="voluntary" value="1" @if($event->isVoluntary()) checked="checked" @endif>

                                        Wolontariat
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="language_learning" value="1" @if($event->isLanguageLearning()) checked="checked" @endif>

                                        Nauka języków
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 50px;text-align: center;">
                            <a href="#" class="btn btn-default btn-lg tab-action change-tab" action-tab-id="tab2">Wstecz</a>
                            <a href="#" class="btn btn-primary btn-lg tab-action change-tab" action-tab-id="tab4">Dalej</a>
                        </div>
                    </div>
                    <!-- tab 3 -->

                    <!-- tab 4 -->
                    <div class="flocc-tab" tab-id="tab4">
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Aktualne zdjęcie</h3><br>

                                <img src="{{ $event->getAvatarUrl() }}">
                            </div>
                            <div class="col-md-8">
                                <h3>Awatar wydarzenia</h3><br>

                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>

                        <div style="margin-top: 50px;text-align: center;">
                            <a href="#" class="btn btn-default btn-lg tab-action change-tab" action-tab-id="tab3">Wstecz</a>
                            <button type="submit" class="btn btn-success btn-lg">Zapisz</button>
                        </div>
                    </div>
                    <!-- tab 4 -->
                </div>
            </form>
        </div>
    </div>

    <script src="/js/theme/events/edit.js"></script>
    <script src="/js/theme/tabs.js"></script>
    <script>
        $(function() {
            FloccThemeEventsEdit.Init();

            @if($event->isPlace())
                FloccThemeEventsEdit.Places.Place().Init();
            @else
                @if(!$event->isStatusDraft())
                    @if(count($post_routes))
                        @foreach($post_routes as $id => $name)
                            FloccThemeEventsEdit.Places.Route.Add({{ $id }}, "{{ $name }}");
                        @endforeach
                    @else
                        @foreach($event->getRoutes() as $place)
                            FloccThemeEventsEdit.Places.Route.Add({{ $place->getId() }}, "{{ $place->getName() }}");
                        @endforeach
                    @endif

                FloccThemeEventsEdit.Places.Route.Init();
                @endif
            @endif
        });
    </script>
@endsection
