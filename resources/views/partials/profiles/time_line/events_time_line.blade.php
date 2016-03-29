<ul class="events">
    <ul>
        @foreach($lines as $line)
            <li>
                <a href="{{ URL::route('events.event', ['slug' => $line['slug']]) }}">
                    {!! $line['message'] !!}<br>
                    <small>{{ $line['date'] }}</small>
                </a>
            </li>
        @endforeach
    </ul>
</ul>