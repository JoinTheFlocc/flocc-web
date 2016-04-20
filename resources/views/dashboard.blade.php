@extends('layouts.app')

@section('content')
    <section id="main">
        <div class="container-fluid mainBoxA">
        <div class="container flocc-search">
            {!! Form::open(['route' => 'events', 'class' => 'form-horizontal']) !!}
            <div class="row">
                <div class="col-md-3">
                    <p>Co</p>
                    <div class="well">
                        <select name="activity_id" class="form-control">
                            <option value="" selected="selected">Wybierz</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->getId() }}">{{ $activity->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>Gdzie</p>
                    <div class="well">
                        <input type="text" name="place" class="form-control place_auto_complete" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-12">
                            <p>Jak</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well">
                                <select name="tribe_id" class="form-control">
                                    <option value="" selected="selected">Wybierz</option>
                                    @foreach($tribes as $tribe)
                                        <option value="{{ $tribe->getId() }}">{{ $tribe->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="row">
                        <div class="col-md-12">
                            <p>&nbsp;</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success btn"><i class="fa fa-btn fa-search"></i> Szukaj</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="
                height: 12px;
                margin-top: 18px;
                color: #00c176;
                text-transform: uppercase;
                font-size: 18px;
                font-weight: 400;">
                    <p></p>
                </div>
            </div>
        </div>
        <div class="container-fluid events-box">
            <div class="container">
            <div class="row">
                <ul class="events">
                    @include('partials.profiles.time_line.events_time_line', array('lines' => $events_time_lines))
                    @include('partials.profiles.time_line.events', array('events' => $profile->getTimeLine()->getEvents(), 'inspiration' => $profile->getTimeLine()->getInspirations()))
                </ul>
                <br/>
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
