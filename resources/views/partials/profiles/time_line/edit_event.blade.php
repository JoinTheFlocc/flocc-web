<h4>
    <i class="fa fa-comment-o"></i> <a href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">Edit event: {{ $event }}</a>
</h4>
<p><a href="{{ URL::route('profile.display', ['id' => $user_id]) }}">{{ $user }}</a> edit event</p>
<p><span class="glyphicon glyphicon-time"></span> {{ $time }}</p>
</p><a class="btn btn-primary" href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">Check Event <span class="glyphicon glyphicon-chevron-right"></span></a>