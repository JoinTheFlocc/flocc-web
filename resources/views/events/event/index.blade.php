@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top:25px;">
            <div class="col-sm-4" style="margin-top:60px;">
                @if(!Auth::guest())
                    @if(!$event->isInspiration())
                        @if($event->isMine() === false)
                            <div class="text-center">
                                @if($event->canJoin())
                                    <a href="{{ URL::route('events.event.join', ['id' => $event->getId(), 'slug' => $event->getSlug(), 'type' => 'member']) }}" class="btn btn-success" style="width:32%">
                                        Dołącz
                                    </a>
                                @endif
                                @if($event->canUnJoin())
                                    <a href="{{ URL::route('events.event.resign', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}" class="btn btn-danger">
                                        Zrezygnuj
                                    </a>
                                @endif

                                @if($event->canFollow())
                                    <a href="{{ URL::route('events.event.join', ['id' => $event->getId(), 'slug' => $event->getSlug(), 'type' => 'follower']) }}" class="btn btn-primary" style="width:32%">
                                        Obserwuj
                                    </a>
                                @endif
                                @if($event->canUnFollow())
                                    <a href="{{ URL::route('events.event.resign', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}" class="btn btn-danger">
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
                                    <a href="{{ URL::route('events.event.cancel', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}" class="btn btn-danger" onclick="return confirm('Na pewno?');">
                                        Odwołaj wydarzenie
                                    </a>
                                @endif
                                <a href="{{ URL::route('events.edit', ['id' => $event->getId()]) }}" class="btn btn-primary">
                                    Edytuj
                                </a>
                            </div><br>
                        @endif
                    @else
                        <div class="text-center">
                            <a href="{{ URL::route('events.new', ['id' => $event->getId()]) }}" class="btn btn-primary">
                                Załóż podobne wydarzenie
                            </a>
                            @if($event->isMine())
                                <a href="{{ URL::route('events.edit', ['id' => $event->getId()]) }}" class="btn btn-primary">
                                    Edytuj
                                </a>
                            @endif
                        </div><br>
                    @endif
                @endif

                <div class="well text-center">
                    <h1>{{ $event->getTitle() }}</h1><br>
                    <img src="{{ $event->getAvatarUrl() }}" style="width:300px;"><br>&nbsp;<br>
                    <p>{{ $event->getDescription() }}</p><br>

                    @if(!$event->isMine() and !Auth::guest() and !$event->isInspiration())
                        <div class="well" style="background:green;color:#fff;">
                            Twoje dopasowanie do wydarzenia:<br>

                            <strong style="font-size:50px;">{{ $event->getUsersScoring($user_id) }}%</strong>
                        </div>
                    @endif

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
                            @if(!$event->isInspiration())
                                <strong>Organizator:</strong><br>
                                <i class="fa fa-user"></i>
                                <a href="{{ URL::route('profile.display', ['id' => $event->getUserId()]) }}">
                                    {{ $event->getOwner()->getProfile()->getFirstName() }} {{ $event->getOwner()->getProfile()->getLastName() }}
                                </a>
                            @else
                                <strong>Proponowany miesiąc:</strong><br>
                                {{ $event->getEventMonthName() }}
                            @endif
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

                            @if($event->getBudget() !== null)
                                {{ $event->getBudget()->getName() }}
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <strong>Intensywność:</strong><br>

                            @if($event->getIntensity() !== null)
                                {{ $event->getIntensity()->getName() }}
                            @endif
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Jak:</strong><br>

                            <ul>
                                @foreach($event->getTribes() as $tribe)
                                    <li>
                                        {{ $tribe->getName() }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <strong>Sposób podróżowani:</strong><br>

                            @if($event->getTravelWays() !== null)
                                {{ $event->getTravelWays()->getName() }}
                            @endif
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Infrastruktura:</strong><br>

                            @if($event->getInfrastructure() !== null)
                                {{ $event->getInfrastructure()->getName() }}
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <strong>Turystyczność:</strong><br>

                            @if($event->getTourist() !== null)
                                {{ $event->getTourist()->getName() }}
                            @endif
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Wolontariat:</strong><br>

                            @if($event->isVoluntary())
                                Tak
                            @else
                                Nie
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <strong>Nauka języków:</strong><br>

                            @if($event->isLanguageLearning())
                                Tak
                            @else
                                Nie
                            @endif
                        </div>
                    </div>
                    <div class="row text-left" style="margin-top:25px;">
                        <div class="col-sm-6">
                            <strong>Planowanie:</strong><br>

                            @if($event->getPlanning() !== null)
                                {{ $event->getPlanning()->getName() }}
                            @endif
                        </div>
                        <div class="col-sm-6">&nbsp;</div>
                    </div>
                </div>

                <div class="well">
                    @foreach($event->getActivities() as $row)
                        <span style="margin-right:10px;"><i class="fa fa-tag"></i> {{ $row->getName() }}</span>
                    @endforeach
                </div>

                @if(!$event->isInspiration())
                    <div class="row" style="margin-top:30px;">
                        <div class="col-sm-6">
                            <strong>Uczestnicy ({{ $event->getMembers()->count() }})</strong>
                            <div class="well" style="margin-top:15px;">
                                @foreach($event->getMembers() as $member)
                                    <?php $profile = $member->getUser()->getProfile(); ?>
                                    <a href="{{ URL::route('profile.display', $profile->getId()) }}" title="{{ $profile->getFirstName() }} {{ $profile->getLastName() }}">
                                        <img src="{{ $profile->getAvatarUrl()}}" alt="{{ $profile->getFirstName() }} {{ $profile->getLastName() }}"  class="img-responsive img-thumbnail img-rounded avatar">
                                    </a>
                                @endforeach
                                <br>&nbsp;<br><a href="{{ URL::route('events.event.members', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}">
                                    Zobacz wszystkich
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <strong>Obserwują ({{ $event->getFollowers()->count() }})</strong>
                            <div class="well" style="margin-top:15px;">
                                @foreach($event->getFollowers() as $member)
                                    <?php $profile = $member->getUser()->getProfile(); ?>
                                    <a href="{{ URL::route('profile.display', $profile->getId()) }}" title="{{ $profile->getFirstName() }} {{ $profile->getLastName() }}">
                                        <img src="{{ $profile->getAvatarUrl()}}" alt="{{ $profile->getFirstName() }} {{ $profile->getLastName() }}" class="img-responsive img-thumbnail img-rounded avatar">
                                    </a>
                                @endforeach
                                <br>&nbsp;<br><a href="{{ URL::route('events.event.followers', ['id' => $event->getId(), 'slug' => $event->getSlug()]) }}">
                                    Zobacz wszystkich
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
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
                    <li @if($comments_label == 'public') class="active" @endif tab-id="comments">
                        <a href="#">Posty</a>
                    </li>
                    @if($event->isImIn() and !$event->isInspiration())
                        <li @if($comments_label == 'private') class="active" @endif tab-id="forum">
                            <a href="#">Forum</a>
                        </li>
                    @endif
                    <li class="pull-right">
                        <a href="#" class="facebook_share" style="background: #3b5998;color:#fff;" facebook-url="{{ $meta_facebook->getUrl() }}" facebook-title="{{ $meta_facebook->getTitle() }}" facebook-img="{{ $meta_facebook->getImage() }}" facebook-desc="{{ $meta_facebook->getDescription() }}">
                            <i class="fa fa-facebook-official"></i>
                        </a>
                    </li>
                </ul>
                <div class="nav" style="border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding: 20px;">

                    <div id="comments" class="tab" @if($comments_label == 'private') style="display: none;" @endif>
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
                    @if($event->isImIn() and !$event->isInspiration())
                        <div id="forum" @if($comments_label == 'public') style="display:none;" @endif class="tab">
                            <h2 style="margin-bottom: 25px;">Forum</h2>

                            <div>
                                @include('partials.events.comments', array('comments' => $event->getComments()))
                            </div>

                            <div>
                                <h2>Nowy temat</h2><br>

                                <form method="POST" action="{{ URL::route('events.comment') }}">
                                    <textarea name="comment" style="width:100%;height:50px;background:#fff; border: 1px solid #000; border-radius:5px;" placeholder="Wpisz swój komentarz"></textarea><br>
                                    <input type="hidden" name="event_id" value="{{ $event->getId() }}">
                                    <input type="hidden" name="label" value="private">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-primary btn-block">Załóż temat</button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <br>&nbsp;<br>
    </div>

    <script>
        $('.nav-tabs li').click(function() {
            var tab = $(this).attr('tab-id');

            $('.nav-tabs li').removeClass('active');
            $('.nav .tab').hide();

            $('#' + tab).show();
            $(this).addClass('active');

            return false;
        });
    </script>
@endsection
