<div class="well">
    <p>{{ $item->getComment() }}</p>

    <div>
        <img src="{{ $item->getUser()->getAvatarUrl() }}" style="width:10px;"> {{ $item->getUser()->getName() }}
        <span class="pull-right">{{ $item->getTime() }}</span>
    </div>
</div>