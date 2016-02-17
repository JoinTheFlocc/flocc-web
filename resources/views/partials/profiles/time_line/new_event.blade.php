<h4>
    <i class="fa fa-map-o"></i> <a href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">New event: {{ $event }}</a>
</h4>
<p>
    Added by <a href="{{ URL::route('profile.display', ['id' => $user_id]) }}">{{ $user }}</a>
</p>
<p><span class="glyphicon glyphicon-time"></span> {{ $time }}</p>
<img class="img-responsive" src="/img/lake-baikal.jpg" alt="">
<p>&nbsp;</p>
<p>{{ $event_description }}</p>
<a class="btn btn-primary" href="{{ URL::route('events.event', ['slug' => $event_slug]) }}">Check Event      <span class="glyphicon glyphicon-chevron-right"></span></a>