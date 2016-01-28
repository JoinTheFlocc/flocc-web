@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin:80px 0;">
            <h1 style="margin-bottom: 50px;">Członkowie wydarzenia</h1>

            <ul class="nav nav-tabs">
                <li role="presentation" class="active">
                    <a href="#" class="tab-action change-tab" action-tab-id="awaiting">
                        Prośba o akceptacje

                        <span class="label label-primary" style="white-space:normal;margin-left:10px;">
                            {{ $event->getAwaitingRequests()->count() }}
                        </span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-action change-tab" action-tab-id="members">
                        Użytkownicy

                        <span class="label label-primary" style="white-space:normal;margin-left:10px;">
                            {{ $event->getMembers()->count() }}
                        </span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-action change-tab" action-tab-id="followers">
                        Obserwujący

                        <span class="label label-primary" style="white-space:normal;margin-left:10px;">
                            {{ $event->getFollowers()->count() }}
                        </span>
                    </a>
                </li>
                <li role="presentation">
                    <a href="#" class="tab-action change-tab" action-tab-id="rejected">
                        Odrzuceni

                        <span class="label label-primary" style="white-space:normal;margin-left:10px;">
                            {{ $event->getRejectedRequests()->count() }}
                        </span>
                    </a>
                </li>
            </ul>

            <div class="nav" style="border-left:1px solid #ddd; border-right:1px solid #ddd; border-bottom:1px solid #ddd; padding: 20px;">
                <div class="flocc-tabs">
                    <div class="flocc-tab" tab-id="awaiting">
                        @include('partials.events.users.list', array('users' => $event->getAwaitingRequests(), 'tab' => 'awaiting'))
                    </div>
                    <div class="flocc-tab" tab-id="members">
                        @include('partials.events.users.list', array('users' => $event->getMembers(), 'tab' => 'members'))
                    </div>
                    <div class="flocc-tab" tab-id="followers">
                        @include('partials.events.users.list', array('users' => $event->getFollowers(), 'tab' => 'followers'))
                    </div>
                    <div class="flocc-tab" tab-id="rejected">
                        @include('partials.events.users.list', array('users' => $event->getRejectedRequests(), 'tab' => 'rejected'))
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/js/theme/tabs.js"></script>
    <script>
        $(function() {
            FloccTabs.Init('awaiting');
        });
    </script>
@endsection
