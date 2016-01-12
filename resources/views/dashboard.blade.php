@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        
        <!-- Profile panel -->
        <div class="col-md-3">
            <div class="well">
                <img src="{{ $profile->avatar_url }}" class="img-thumbnail">
                <h4 style="color: royalblue;">{{ $profile->firstname . " " . $profile->lastname }}</h4>
                <p><i class="fa fa-map-marker"></i> Poland</p>
                <p>{{ $profile->description }}</p>
                <div class="row">
                    <div class="col-sm-offset-4 col-sm-4">
                        <i class="fa fa-inbox"></i> <span class="badge">12</span>
                    </div>
                    <div class="col-sm-4">
                        <i class="fa fa-flag"></i> <span class="badge">3</span>
                    </div>
                </div>
                <br>
                @if(!$is_mine)
                    <a href="{{ URL::route('mail.new.form', ['user_id' => $profile->user_id]) }}" class="btn btn-success btn-block">
                        <i class="fa fa-envelope"></i> Start chat
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
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">All</a>
                </li>
                <li><a href="#">My Events</a>
                </li>
                <li><a href="#">Notifications</a>
                </li>
            </ul>
            <hr>
            <!--
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
            //-->
            <h4>
                <i class="fa fa-user-plus"></i> <a href="#">New member: Sailing trip around Crete</a>
            </h4>
            <p>
                <a href="index.php">Jane Noname</a> joined
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Jan 4, 2015 at 03:15 AM</p>
            <a class="btn btn-primary" href="#">Check Event <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>
            
            <h4>
                <i class="fa fa-map-o"></i> <a href="#">New event: Baikal Kayaking</a>
            </h4>
            <p>
                Added by <a href="#">Flocc</a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Jan 2, 2016 at 10:00 PM</p>
            <img class="img-responsive" src="/img/lake-baikal.jpg" alt="">
            <p>&nbsp;</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore, veritatis, tempora, necessitatibus inventore nisi quam quia repellat ut tempore laborum possimus eum dicta id animi corrupti debitis ipsum officiis rerum.</p>
            <a class="btn btn-primary" href="#">Check Event      <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <h4>
                <i class="fa fa-comment-o"></i> <a href="#">New comment: Thailand semi-pro backpacking</a>
            </h4>
            <p>Posted by <a href="#">Joe Sixpack</a></p>
            <p><span class="glyphicon glyphicon-time"></span> Dec 28, 2016 at 10:45 AM</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam, quasi, fugiat, asperiores harum voluptatum tenetur a possimus nesciunt quod accusamus saepe tempora ipsam distinctio minima dolorum perferendis labore impedit voluptates!</p>
            <a class="btn btn-primary" href="#">Check Event <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <!-- Pager -->
            <ul class="pager">
                <li class="previous">
                    <a href="#">&larr; Older</a>
                </li>
                <li class="next">
                    <a href="#">Newer &rarr;</a>
                </li>
            </ul>

        </div>
    </div>
@endsection