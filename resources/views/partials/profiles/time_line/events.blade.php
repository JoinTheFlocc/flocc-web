{{-- */$i = 0;/*--}}
@foreach($events as $event)
    {{-- */$i++;/*--}}
    @if($i == 3)
        @include('partials.profiles.time_line.inspiration', array('inspiration' => $inspiration[0]))
    @endif
<li class="col-md-3">
    <div class="event-block">
        <div class="event-img">
            <img src="{{ $event->getAvatarUrl() }}"/>
            <div style="position: relative; margin-top: -55px; margin-left:200px;">
                <img src="{{ $event->getOwner()->getProfile()->getAvatarUrl() }}" class="img-thumbnail img-circle" style="width:80px;"/>
            </div>
        </div>
        <div class="event-info">
            <h2>
                <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                    {{ $event->getTitle() }}
                </a>
            </h2>
            <div class="well">
                <p>Organizator: {{ $event->getOwner()->getProfile()->getFirstName() }} {{ $event->getOwner()->getProfile()->getLastName() }}</p>
                <p><i class="fa fa-btn fa-users"></i> <strong>{{ $event->getMembers()->count() }}</strong> |
                <i class="fa fa-btn fa-binoculars"></i> <strong>{{ $event->getFollowers()->count() }}</strong> |
                <i class="fa fa-btn fa-comments"></i> <strong>{{ $event->getComments()->count() }}</strong>
                </p>
                <p><i class="fa fa-btn fa-calendar"></i> {{ $event->getEventFrom() }}-{{ $event->getEventTo() }} ({{ $event->getEventSpan() }} dni)</p>
                <p>
                @if($event->isPlace())
                    <i class="fa fa-btn fa-map-marker"></i> <strong>{{ $event->getPlace()->getName() }}</strong>
                @else
                    <i class="fa fa-btn fa-map-signs"></i> <strong>@foreach($event->getRoutes() as $place) {{ $place->getName() }} > @endforeach</strong>
                @endif
                </p>
            </div>
        </div>
    </li>
</li>
@endforeach
