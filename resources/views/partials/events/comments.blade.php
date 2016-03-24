@foreach($comments as $comment)
    <div class="well">
        <p>{{ $comment->getComment() }}</p>
        <div>
            <i class="fa fa-user"></i>
            {{ $comment->getUser()->getProfile()->getFirstName() }}
            {{ $comment->getUser()->getProfile()->getLastName() }}
        </div>

        @if(count($comment->getChildrens()) > 0)
            <ul>
                @foreach($comment->getChildrens() as $children)
                    <li>
                        <p>{{ $children->getComment() }}</p>
                        <div>
                            <i class="fa fa-user"></i>
                            {{ $children->getUser()->getProfile()->getFirstName() }}
                            {{ $children->getUser()->getProfile()->getLastName() }}
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif

        <form method="POST" action="{{ URL::route('events.comment') }}">
            <textarea name="comment" style="width:100%;height:50px;background:#fff; border: 1px solid #000; border-radius:5px;" placeholder="Wpisz swój komentarz"></textarea><br>
            <input type="hidden" name="event_id" value="{{ $comment->getEventId() }}">
            <input type="hidden" name="parent_id" value="{{ $comment->getId() }}">
            <input type="hidden" name="label" value="private">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary btn-block">Odpowiedz</button>
        </form>
    </div>
@endforeach