@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-4">
                <div class="text-center" style="margin-bottom:25px;">
                    @if($event->isMine() and $event->isStatusActive())
                        <a href="#" class="btn btn-success" style="width:32%">
                            Dołącz
                        </a>
                        <a href="#" class="btn btn-primary" style="width:32%">
                            Obserwuj
                        </a>
                    @endif
                    <a href="{{ URL::route('mail.new.form', ['user_id' => $event->getUserId()]) }}" class="btn btn-default" style="width:32%">
                        Wiadomość
                    </a>
                </div>

                <div class="well text-center">
                    <h1>{{ $event->getTitle() }}</h1><br>
                    <img src="{{ $event->getAvatarUrl() }}" style="width:150px;border-radius:5px;"><br><br>
                    <p>{{ $event->getDescription() }}</p><br>

                    <div class="row">
                        <div class="col-sm-6">
                            <i class="fa fa-map"></i> {{ $event->getPlace()->getName() }}
                        </div>
                        <div class="col-sm-6">
                            <i class="fa fa-user"></i>
                            <a href="{{ URL::route('profile.display', ['id' => $event->getUserId()]) }}">
                                {{ $event->getOwner()->getProfile()->getFirstName() }} {{ $event->getOwner()->getProfile()->getLastName() }}
                            </a>
                        </div>
                    </div>
                    <div class="row" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <i class="fa fa-info"></i>

                            @if($event->isStatusActive())
                                @if($event->isFixed())
                                    Odbędzie się
                                @else
                                    Planowane
                                @endif
                            @else
                                Anulowane
                            @endif
                        </div>
                        <div class="col-sm-6">

                        </div>
                    </div>
                </div>

                <div class="well">
                    @foreach($event->getActivities() as $row)
                        <span style="margin-right:10px;"><i class="fa fa-tag"></i> {{ $row->getName() }}</span>
                    @endforeach
                </div>

                <div class="row" style="margin-top:30px;">
                    <div class="col-sm-6">
                        <strong>Uczestnicy ({{ $event->getMembers()->count() }})</strong>

                        <div class="well" style="margin-top:15px;">
                            @foreach($event->getMembers() as $member)
                                <a href="{{ URL::route('profile.display', ['id' => $member->getUserId()]) }}" title="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                    <img src="{{ $member->getUser()->getProfile()->getAvatarUrl()}}" alt="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}" style="border-radius:5px;">
                                </a>
                            @endforeach

                            <br>&nbsp;<br><a href="{{ URL::route('events.event.members', ['slug' => $event->getSlug()]) }}">
                                Zobacz wszystkich
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <strong>Obserwują ({{ $event->getFollowers()->count() }})</strong>

                        <div class="well" style="margin-top:15px;">
                            @foreach($event->getFollowers() as $member)
                                <a href="{{ URL::route('profile.display', ['id' => $member->getUserId()]) }}" title="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                    <img src="{{ $member->getUser()->getProfile()->getAvatarUrl()}}" alt="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                </a>
                            @endforeach

                            <br>&nbsp;<br><a href="{{ URL::route('events.event.followers', ['slug' => $event->getSlug()]) }}">
                                Zobacz wszystkich
                            </a>
                        </div>
                    </div>
                </div>

                @if($event->isMine() and $event->isStatusActive())
                    <a href="{{ URL::route('events.event.cancel', ['slug' => $event->getSlug()]) }}" class="btn btn-danger btn-block" onclick="return confirm('Na pewno?');">
                        Odwołaj wydarzenie
                    </a>
                @endif
            </div>
            <div class="col-sm-8">
                @if($event->isStatusCanceled())
                    <div class="alert alert-danger" style="margin-top:58px;">
                        To wydarzenie zostało odwołane
                    </div>
                @endif
                <ul class="nav nav-tabs" style="margin-top:58px;">
                    <li class="active">
                        <a href="#">Posty</a>
                    </li>
                    <li>
                        <a href="#">Udostępnij wydarzenie</a>
                    </li>
                </ul>
                <div class="nav" style="border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding: 20px;">
                    <div class="well">
                        <textarea style="width:100%;height:50px;background: transparent; border: 0;" placeholder="Wpisz swój komentarz"></textarea><br>
                        <button class="btn btn-primary btn-block">Skomentuj</button>
                    </div>

                    <div style="margin-top:50px;">
                        <h2 style="margin-bottom: 25px;">Time line</h2>

                        @foreach($event->getTimeLine() as $item)
                            @include('partials.events.time_line.' . $item->getType(), array('item' => $item))
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
