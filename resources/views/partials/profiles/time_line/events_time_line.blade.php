<li class="col-md-3">
    <div class="event-block">
        <div class="event-img">
        </div>
        <div class="event-info">
            <h2>
                Kiedy Cię nie było:
            </h2>
            <div class="well">
            @foreach($lines as $line)
                <p>
                    <a href="{{ URL::route('events.event', ['slug' => $line['slug']]) }}">
                        {!! $line['message'] !!}<br>
                        <small>{{ $line['date'] }}</small>
                    </a>
                </p>
            @endforeach                
            </div>
        </div>
    </div>
</li>
