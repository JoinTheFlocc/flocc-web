<h4>
    <i class="fa fa-comment-o"></i> <a href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">New comment: {{ $event }}</a>
</h4>
<p>Posted by <a href="{{ URL::route('profile.display', ['id' => $user_id]) }}">{{ $user }}</a></p>
<p><span class="glyphicon glyphicon-time"></span> {{ $time }}</p>
<p>{{ $comment }}</p>
</p><a class="btn btn-primary" href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">Check Event <span class="glyphicon glyphicon-chevron-right"></span></a>