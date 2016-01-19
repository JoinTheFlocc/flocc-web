@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-4">
                <div class="text-center" style="margin-bottom:25px;">
                    <a href="#" class="btn btn-success" style="width:32%">
                        Dołącz
                    </a>
                    <a href="#" class="btn btn-primary" style="width:32%">
                        Obserwuj
                    </a>
                    <a href="{{ URL::route('mail.new.form', ['user_id' => $event->getUserId()]) }}" class="btn btn-default" style="width:32%">
                        Wiadomość
                    </a>
                </div>

                <div class="well text-center">
                    <h1>{{ $event->getTitle() }}</h1><br>
                    <img src="{{ $event->getPhoto() }}" style="width:150px;border-radius:5px;"><br><br>
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
                                    <img src="http://a.deviantart.net/avatars/a/v/avatar239.jpg?2" alt="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}" style="border-radius:5px;">
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <strong>Obserwują ({{ $event->getFollowers()->count() }})</strong>

                        <div class="well" style="margin-top:15px;">
                            @foreach($event->getFollowers() as $member)
                                <a href="{{ URL::route('profile.display', ['id' => $member->getUserId()]) }}" title="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                    <img src="http://a.deviantart.net/avatars/a/v/avatar239.jpg?2" alt="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
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
                        <h2 style="margin-bottom: 25px;">Posty</h2>

                        @foreach($event->getComments() as $comment)
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object" src="http://a.deviantart.net/avatars/a/v/avatar239.jpg?2" style="border-radius: 5px;">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{ $comment->getUser()->getProfile()->getFirstName() }} {{ $comment->getUser()->getProfile()->getLastName() }}</h4>
                                    <p>{{ $comment->getComment() }}</p>

                                    @if(count($comment->getComments()) > 0)
                                        <div style="margin-top: 20px;padding-left: 40px">
                                            @foreach($comment->getComments() as $sub_comment)
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                            <img class="media-object" src="http://a.deviantart.net/avatars/a/v/avatar239.jpg?2" style="border-radius: 5px;">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <h4 class="media-heading">{{ $sub_comment->getUser()->getProfile()->getFirstName() }} {{ $sub_comment->getUser()->getProfile()->getLastName() }}</h4>
                                                        <p>{{ $sub_comment->getComment() }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
