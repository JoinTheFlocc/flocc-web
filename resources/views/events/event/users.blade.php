@extends('layouts.app')

@section('content')
    <div class="container">
        <div>
            <h1 class="pull-left">Użytkownicy</h1>

            <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}" class="btn btn-primary pull-right" style="margin-top:25px;">
                Powrót do wydarzenia
            </a>
        </div>
        <br class="clearfix">&nbsp;<br class="clearfix">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Imię i nazwisko</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $member)
                    <tr>
                        <td>
                            <img src="{{ $member->getUser()->getProfile()->getAvatarUrl()}}">
                        </td>
                        <td>
                            <a href="{{ URL::route('profile.display', ['id' => $member->getUserId()]) }}" title="{{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}">
                                {{ $member->getUser()->getProfile()->getFirstName() }} {{ $member->getUser()->getProfile()->getLastName() }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
