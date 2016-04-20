@extends('layouts.app');
@section('content')
<section id="main">

    <div class="container-fluid welcome">
        <div class="container intro-over">
            <a href="http://instagram.com/jointheflocc"><i class="fa fa-2x fa-instagram pull-right"></i></a>
            <!-- <i class="fa fa-2x fa-twitter-square pull-right"></i> //-->
            <a href="https://www.facebook.com/jointheflocc/"><i class="fa fa-2x fa-facebook-square pull-right"></i></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 intro-heading">
                    <h1>Flocc<span style="color:#ff6d00">.</span></h1>
                    <p>Jaka jest Twoja następna przygoda<span style="color:#ff6d00">?</span></p>
                </div>
            </div>
        </div>
        <div class="container flocc-search">
            {!! Form::open(['route' => 'events', 'class' => 'form-horizontal']) !!}
                <div class="row">
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <p>Gdzie</p>
                        <div class="well">
                            <input type="text" name="place" class="form-control place_auto_complete" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <p>Jak</p>
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
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-btn fa-search"></i> Szukaj</button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12" style="
            margin-top: 18px;
            color: #00c176;
            text-transform: uppercase;
            font-size: 18px;
            font-weight: 400;">
                <p>Ostatnio dodane:</p>
            </div>
        </div>
    </div>
    <div class="container-fluid events-box">
        <div class="container">
        <div class="row">
            <ul class="events">
                @foreach($events as $event)
                <li class="col-md-3">
                    <div class="event-block">
                        <div class="event-img">
                            <img src="{{ $event->getAvatarUrl() }}"/>
                            <div style="position: relative; margin-top: -55px; margin-left:200px;">
                                <img src="{{ $event->getOwner()->getProfile()->getAvatarUrl() }}" class="img-thumbnail img-circle" style="width:80px;"/>
                            </div>
                        </div>
                        <div class="event-info">
                            <h2>
                                <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                                    {{ $event->getTitle() }}
                                </a>
                            </h2>
                            <div class="well">
                                <p>Organizator: {{ $event->getOwner()->getProfile()->getFirstName() }} {{ $event->getOwner()->getProfile()->getLastName() }}</p>
                                <p><i class="fa fa-btn fa-users"></i> <strong>{{ $event->getMembers()->count() }}</strong> |
                                <i class="fa fa-btn fa-binoculars"></i> <strong>{{ $event->getFollowers()->count() }}</strong> |
                                <i class="fa fa-btn fa-comments"></i> <strong>{{ $event->getComments()->count() }}</strong>
                                </p>
                                <p><i class="fa fa-btn fa-calendar"></i> {{ $event->getEventFrom() }}-{{ $event->getEventTo() }} ({{ $event->getEventSpan() }} dni)</p>
                                <p>
                                @if($event->isPlace())
                                    <i class="fa fa-btn fa-map-marker"></i> <strong>{{ $event->getPlace()->getName() }}</strong>
                                @else
                                    <i class="fa fa-btn fa-map-signs"></i> <strong>@foreach($event->getRoutes() as $place) {{ $place->getName() }} > @endforeach</strong>
                                @endif
                                </p>
                            </div>
                        </div>
                    </li>
                </li>
                @endforeach
            </ul>
            <br/>
        </div>
        </div>
    </div>
<!--
    <div class="container">
        <div class="row">
            <div class="col-md-12 intro-welcome">
                <h3>Join a community of like-minded travellers</h3>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </p>
            </div>
        </div>
    </div>
//-->
<div class="container">
    <div class="row">
        <div class="col-lg-12" style="
        margin-top: 18px;
        color: #00c176;
        text-transform: uppercase;
        font-size: 18px;
        font-weight: 400;">
            <p>#Jointheflocc:</p>
        </div>
    </div>
</div>
    <div class="container content-welcome">
        <div class="row">
            <div class="col-md-4">
                <div class="photobox box-red">
                    <img src="/img/flocc1.jpg" class="img-thumbnail" alt="Chania">
                </div>
            </div>
            <div class="col-md-4">
                <div class="photobox box-yellow">
                    <img src="/img/carousel2.jpg" class="img-thumbnail" alt="Chania">
                </div>
            </div>
            <div class="col-md-4">
                <div class="photobox box-green">
                    <img src="/img/flocc3.jpg" class="img-thumbnail" alt="Chania">
                </div>
            </div>
        </div>
    </div>
<!--
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 outro-welcome">
                    <h2>Nie czekaj, dołącz do Flocc!</h2>
                </div>
            </div>
        </div>
    </div>
//-->
<div class="container">
    <div class="row">
        <div class="col-lg-12" style="
        height: 40px;
        margin-top: 18px;
        color: #00c176;
        text-transform: uppercase;
        font-size: 18px;
        font-weight: 400;">
            <p></p>
        </div>
    </div>
</div>
</section>
@endsection
