@extends('layouts.app')

@section('content')
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row" style="padding:20px;">
                        <form method="POST" action="{{ URL::route('mail.new') }}">
                            <h2>{{ $user->name }}</h2><br>

                            <textarea name="message" class="form-control" rows="3" placeholder="Message here" required="required"></textarea><br>
                            <input type="hidden" name="users[]" value="{{ $user->id }}">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-primary">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
