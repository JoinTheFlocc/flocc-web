@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            <h1>Wydarzenia</h1><br>

            <a href="{{ URL::route('events.new') }}" class="btn btn-success">
                Utwórz nowe wydarzenie
            </a><br>&nbsp;<br>

            wyszukiwarka wydarzen
        </div>
    </div>
@endsection
