@extends('layouts.app')
@section('content')
    <section id="main">
        <div class="container mainBoxA">
            <div class="contentBox">
                <div class="row">
                    <div class="col-md-3">
                        <div class="well">
                            <img src="{{ $profile->avatar_url }}" class="img-thumbnail">
                            <h4 style="color: royalblue;">{{ $profile->firstname . " " . $profile->lastname }}</h4>
                            <p><i class="fa fa-map-marker"></i> Poland</p>
                            <p>{{ $profile->description }}</p>
                            <br>
                            @if(!$is_mine)
                                <a href="{{ URL::route('mail.new.form', ['user_id' => $profile->user_id]) }}" class="btn btn-success btn-block">
                                    <i class="fa fa-envelope"></i> Start chat
                                </a>
                            @else
                                <a href="{{ URL::route('profile.edit', ['id' => $profile->id]) }}" class="btn btn-success btn-block">
                                    <i class="fa fa-edit"></i> Edit profile
                                </a>
                            @endif
                        </div>

                        <!-- Tags Well -->
                        <div class="well">
                            <h4>Character Cloud </h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="label label-info"><i class="fa fa-hashtag"></i> CharacterTag
                                        </li>
                                        <li class="label label-info"><i class="fa fa-hashtag"></i> CharacterTag
                                        </li>
                                        <li class="label label-info"><i class="fa fa-hashtag"></i> CharacterTag
                                        </li>
                                        <li class="label label-info"><i class="fa fa-hashtag"></i> CharacterTag
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-6 -->
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="label label-success"><i class="fa fa-hashtag"></i> HobbyTag
                                        </li>
                                        <li class="label label-success"><i class="fa fa-hashtag"></i> HobbyTag
                                        </li>
                                        <li class="label label-success"><i class="fa fa-hashtag"></i> HobbyTag
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.col-md-6 -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>
                    <!-- Dashboard content -->
                    <div class="col-md-9">
                        <ul class="nav nav-tabs" id="time_line_tabs">
                            <li role="presentation" type="all" class="active"><a href="#">Wszystkie</a></li>
                            <li role="presentation" type="owner"><a href="#">Organizuję</a></li>
                            <li role="presentation" type="member"><a href="#">Biorę udział</a></li>
                            <li role="presentation" type="follower"><a href="#">Obserwuje</a></li>
                        </ul>

                        <div>
                            <ul id="time_line"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="/js/theme/scroll.js"></script>
    <script>
        $(function() {
            Flocc.Profile.TimeLine.Init();
            Flocc.Profile.TimeLine.Get({{ $id }});
            FloccThemeScroll.Init('#time_line', function(start) {
                Flocc.Profile.TimeLine.Get({{ $id }}, Flocc.Profile.TimeLine.GetActiveType(), start, 1);
            });
            Flocc.Profile.TimeLine.Tabs(function(type) {
                Flocc.Profile.TimeLine.Init();
                Flocc.Profile.TimeLine.Get({{ $id }}, type);
            });
        });
    </script>
@endsection
