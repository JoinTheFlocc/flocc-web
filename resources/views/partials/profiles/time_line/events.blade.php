<ul class="events">
    @foreach($events as $event)
        <li @if($event->isMine() and !$event->isInspiration()) class="mine-event" style="border: 1px solid red;" @endif>
            <h3>
                <a href="{{ URL::route('events.event', ['slug' => $event->getSlug()]) }}">
                    {{ $event->getTitle() }}
                </a>
            </h3>
            <div class="event-photo">
                <img src="{{ $event->getAvatarUrl() }}">
            </div>
            <div class="event-footer">
                <div class="event-place">
                    @if($event->isPlace())
                        {{ $event->getPlace()->getName() }}
                    @else
                        @foreach($event->getRoutes() as $place)
                            {{ $place->getName() }} >
                        @endforeach
                    @endif
                </div>
                <div class="event-date">
                    @if(!$event->isInspiration())
                        {{ $event->getEventFrom() }}-{{ $event->getEventTo() }}
                    @else
                        {{ $event->getEventMonthName() }}
                    @endif
                </div>
            </div>
        </li>
    @endforeach
</ul>