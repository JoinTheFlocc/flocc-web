@extends('layouts.app')

@section('content')
    <section id="main">
        <div class="container mainBoxA">
            <div class="contentBox">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <a href="{{ URL::route('profile.edit', ['id' => $profile->getUserId()]) }}" class="btn btn-default">
                            Edytuj profil
                        </a>
                        <a href="{{ URL::route('profile.edit.settings', ['id' => $profile->getUserId()]) }}" class="btn btn-default">
                            Ustawienia profilu
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-12">
                        <form method="post" action="{{ URL::route('events') }}">
                            {{ csrf_field() }}

                            <div class="row" style="margin:80px 0;">
                                <div class="col-lg-3">
                                    <h1>Co</h1>

                                    <div class="well">
                                        <select name="activity_id" class="form-control">
                                            <option value="" selected="selected">Wybierz</option>
                                            @foreach($activities as $activity)
                                                <option value="{{ $activity->getId() }}">{{ $activity->getName() }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <h1>Gdzie</h1>

                                    <div class="well">
                                        <input type="text" name="place" class="form-control place_auto_complete" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <h1>Jak</h1>

                                    <div class="well">
                                        @foreach($tribes as $tribe)
                                            <label>
                                                <input type="checkbox" name="tribes[]" value="{{ $tribe->getId() }}">{{ $tribe->getName() }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-lg-3" style="padding-top: 90px;">
                                    <button type="submit" class="btn btn-success btn-block">Szukaj</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Dashboard content -->
                    <div class="col-md-12">
                        <h1>Kiedy Cię nie było</h1>
                        <div>
                            @include('partials.profiles.time_line.events_time_line', array('lines' => $events_time_lines))
                        </div>
                        <hr>

                        <h2>Inspiracje</h2>
                        <div>
                            @include('partials.profiles.time_line.events', array('events' => $profile->getTimeLine()->getInspirations()))
                        </div>
                        <hr>

                        <h2>Wydarzenia</h2>
                        <div>
                            @include('partials.profiles.time_line.events', array('events' => $profile->getTimeLine()->getEvents()))
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('bottomscripts')
    <script src="/js/theme/scroll.js"></script>
    <script>
        $(function() {
            Flocc.Profile.TimeLine.Init();
            Flocc.Profile.TimeLine.Get({{ $profile->user_id }});
            FloccThemeScroll.Init('#time_line', function(start) {
                Flocc.Profile.TimeLine.Get({{ $profile->user_id }}, Flocc.Profile.TimeLine.GetActiveType(), start, 1);
            });
            Flocc.Profile.TimeLine.Tabs(function(type) {
                Flocc.Profile.TimeLine.Init();
                Flocc.Profile.TimeLine.Get({{ $profile->user_id }}, type);
            });
        });
    </script>
@endsection
