@extends('layouts.app');
@section('content')
<section id="main">
    <div class="container-fluid welcome">
        <div class="container intro-over">
            <i class="fa fa-2x fa-instagram pull-right"></i>
            <i class="fa fa-2x fa-twitter-square pull-right"></i>
            <i class="fa fa-2x fa-facebook-square pull-right"></i>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 intro-heading">
                    <h1>Flocc</h1>
                    <p>do things you like with people like you</p>
                </div>
            </div>
        </div>
        <div class="container">
            {!! Form::open(['route' => 'tbd', 'class' => 'form-horizontal']) !!}
            <div class="col-sm-6 col-sm-offset-3">
                <div class="input-group">
                    <!--
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary pull-left">
                            <i class="fa fa-btn fa-map-signs"></i>
                        </button>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary pull-left">
                            <i class="fa fa-btn fa-calendar"></i>
                        </button>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-primary pull-left">
                            <i class="fa fa-btn fa-calendar"></i>
                        </button>
                    </span>
                    //-->
                    {!! Form::text('search', null, ['class' => 'form-control']) !!}
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-success pull-right">
                            <i class="fa fa-btn fa-search"></i> Search
                        </button>
                    </span>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="container-fluid">
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

    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12 outro-welcome">
                    <blockquote class="pull-right">
                        <p>Single best thing that happened to independent travel since hitch-hiking.</p>
                        <small>by <cite>Marco Polo</cite></small>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
