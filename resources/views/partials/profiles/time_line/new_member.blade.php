<h4>
    <i class="fa fa-user-plus"></i> <a href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">New member: {{ $event }}</a>
</h4>
<p>
    <a href="{{ URL::route('profile.display', ['id' => $user_id]) }}">{{ $user }}</a> joined
</p>
<p><span class="glyphicon glyphicon-time"></span> {{ $time }}</p>
<a class="btn btn-primary" href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">Check Event <span class="glyphicon glyphicon-chevron-right"></span></a>