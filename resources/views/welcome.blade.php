@extends('layouts.app');

@section('content')

<div class="container">
    <div class="jumbotron">
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <div class="carousel-caption">
                        <h1>Flocc</h1>
                        <p>do things you like with people like you</p>
                    </div>
                    <img src="/img/carousel1.jpg" class="img-rounded" alt="Chania">
                </div>
                <div class="item">
                    <img src="/img/carousel2.jpg" class="img-rounded" alt="Chania">
                </div>
                <div class="item">
                    <img src="/img/carousel3.jpg" class="img-rounded" alt="Flower">
                </div>
            </div>
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>

@if (isset($user))
    dd($user)
@endif

@endsection
