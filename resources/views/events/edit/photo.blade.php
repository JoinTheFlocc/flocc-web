@extends('layouts.app')

@section('content')
    <div id="event.edit" class="container">
        <div class="row" style="margin:100px 0;">
            <h1 style="text-align: center;">Edycja wydarzenia</h1>

            @if (count($errors) > 0)
                <div class="alert alert-danger" style="margin-top:50px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="form-horizontal" method="post" enctype="multipart/form-data" style="margin:50px 0;">
                {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-4">
                        <h3>Aktualne zdjęcie</h3><br>

                        <img src="{{ $event->getAvatarUrl() }}">
                    </div>
                    <div class="col-md-8">
                        <h3>Nowe zdjęcie</h3><br>

                        <input type="file" name="photo"><br>
                        <input type="submit" value="Zapisz" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
