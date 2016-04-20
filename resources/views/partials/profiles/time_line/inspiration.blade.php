<li class="col-md-3">
    <div class="event-block-inverse">
        <div class="event-img">
            <img src="{{ $inspiration->getAvatarUrl() }}"/>
            <div style="position: relative; margin-top: -55px; margin-left:200px;">
                <img src="/img/idea-clipart-idea.png" class="img-thumbnail img-circle" style="width:80px;"/>
            </div>
        </div>
        <div class="event-info-inverse">
            <h2>
                <a href="{{ URL::route('events.event', ['slug' => $inspiration->getSlug()]) }}">
                    {{ $inspiration->getTitle() }}
                </a>
            </h2>
            <div class="well">
                <p><i class="fa fa-btn fa-calendar"></i> {{ $inspiration->getEventMonthName() }}</p>
                <p>
                @if($inspiration->isPlace())
                    <i class="fa fa-btn fa-map-marker"></i> <strong>{{ $inspiration->getPlace()->getName() }}</strong>
                @else
                    <i class="fa fa-btn fa-map-signs"></i> <strong>@foreach($inspiration->getRoutes() as $place) {{ $place->getName() }} > @endforeach</strong>
                @endif
                </p>
            </div>
        </div>
    </li>
</li>
