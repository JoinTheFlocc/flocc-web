@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="post">
            {{ csrf_field() }}

            <div class="row" style="margin:80px 0;">
                <div class="col-lg-4">
                    <h1>Co</h1>

                    <div class="well">
                        <select name="activity_id" class="form-control">
                            <option value="" selected="selected">Wybierz</option>
                            @foreach($activities as $activity)
                                <option value="{{ $activity->getId() }}">{{ $activity->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">
                    <h1>Gdzie</h1>

                    <div class="well">
                        <input type="text" name="place" class="form-control place_auto_complete" autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-4">
                    <h1>Jak</h1>

                    <div class="well">
                        <select name="tribe_id" class="form-control">
                            <option value="" selected="selected">Wybierz</option>
                            @foreach($tribes as $tribe)
                                <option value="{{ $tribe->getId() }}">{{ $tribe->getName() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <button type="submit" class="btn btn-success btn-lg">Szukaj</button>
                </div>
            </div>
        </form>
        &nbsp;
    </div>
@endsection
