@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-4" style="margin-top:60px;">
                @if(!Auth::guest())
                    @if($event->isMine() === false)
                        <div class="text-center">
                            @if($event->canJoin())
                                <a href="{{ URL::route('events.event.join', ['slug' => $event->getSlug(), 'type' => 'member']) }}" class="btn btn-success" style="width:32%">
                                    Dołącz
                                </a>
                            @endif
                            @if($event->canUnJoin())
                                <a href="{{ URL::route('events.event.resign', ['slug' => $event->getSlug()]) }}" class="btn btn-danger">
                                    Zrezygnuj
                                </a>
                            @endif

                            @if($event->canFollow())
                                <a href="{{ URL::route('events.event.join', ['slug' => $event->getSlug(), 'type' => 'follower']) }}" class="btn btn-primary" style="width:32%">
                                    Obserwuj
                                </a>
                            @endif
                            @if($event->canUnFollow())
                                <a href="{{ URL::route('events.event.resign', ['slug' => $event->getSlug()]) }}" class="btn btn-danger">
                                    Nie obserwuj
                                </a>
                            @endif

                            <a href="{{ URL::route('mail.new.form', ['user_id' => $event->getUserId()]) }}" class="btn btn-default" style="width:32%">
                                Wiadomość
                            </a>
                        </div><br>
                    @else
                        <div class="text-center">
                            @if(!$event->isStatusCanceled())
                                <a href="{{ URL::route('events.event.cancel', ['slug' => $event->getSlug()]) }}" class="btn btn-danger" onclick="return confirm('Na pewno?');">
                                    Odwołaj wydarzenie
                                </a>
                            @endif
                            <a href="{{ URL::route('events.edit', ['id' => $event->getId()]) }}" class="btn btn-primary">
                                Edytuj
                            </a>
                        </div><br>
                    @endif
                @endif

                <div class="well text-center">
                    <h1>{{ $event->getTitle() }}</h1><br>
                    <img src="{{ $event->getAvatarUrl() }}" style="width:300px;"><br>&nbsp;<br>
                    <p>{{ $event->getDescription() }}</p><br>

                    <div class="row text-left">
                        <div class="col-sm-6">
                            <strong>Miejsce:</strong><br>
                            @if($event->isPlace())
                                {{ $event->getPlace()->getName() }}
                            @else
                                <ul>
                                    @foreach($event->getRoutes() as $place)
                                        <li>
                                            {{ $place->getName() }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <strong>Organizator:</strong><br>
                            <i class="fa fa-user"></i>
                            <a href="{{ URL::route('profile.display', ['id' => $event->getUserId()]) }}">
                                {{ $event->getOwner()->getProfile()->getFirstName() }} {{ $event->getOwner()->getProfile()->getLastName() }}
                            </a>
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Typ:</strong><br>
                            <i class="fa fa-info"></i>

                            @if(!$event->isStatusCanceled())
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
                            <strong>Data:</strong><br>
                            {{ $event->getEventFrom() }}-{{ $event->getEventTo() }}
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Budżet:</strong><br>

                            {{ $event->getBudget()->getName() }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Intensywność:</strong><br>

                            {{ $event->getIntensity()->getName() }}
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
            </div>
            <div class="col-sm-8">
                @if($event->isStatusCanceled())
                    <div class="alert alert-danger" style="margin-top:58px;">
                        To wydarzenie zostało odwołane
                    </div>
                @endif

                @if (isset($message))
                    <div class="flash-message" style="margin-top: 115px;">
                        <p class="alert alert-info">{{ $message }}</p>
                    </div>
                @endif

                <ul class="nav nav-tabs" style="margin-top:58px;">
                    <li class="active">
                        <a href="#">Posty</a>
                    </li>
                    <li class="pull-right">
                        <a href="#" style="background: #3b5998;color:#fff;" class="facebook_share" facebook-url="{{ $meta_facebook->getUrl() }}">
                            <i class="fa fa-facebook-official"></i>
                        </a>
                    </li>
                </ul>
                <div class="nav" style="border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding: 20px;">
                    <div class="well">
                        <form method="POST" action="{{ URL::route('events.comment') }}">
                            <textarea name="comment" style="width:100%;height:50px;background: transparent; border: 0;" placeholder="Wpisz swój komentarz"></textarea><br>
                            <input type="hidden" name="event_id" value="{{ $event->getId() }}">
                            @if(!Auth::guest())
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary btn-block">Skomentuj</button>
                            @else
                                <p style="color:#ddd;text-align:center;">Prosimy się zalogować</p>
                            @endif
                        </form>
                    </div>

                    <div style="margin-top:50px;">
                        <h2 style="margin-bottom: 25px;">Time line</h2>

                        @foreach($event->getTimeLine() as $item)
                            <div style="margin: 25px 0;">
                                @include('partials.events.time_line.' . $item->getType(), array('item' => $item))
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <br>&nbsp;<br>
    </div>
@endsection
