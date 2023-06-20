<a href="/post/{{$item['id']}}" class="list-group-item list-group-item-action">
    <img class="avatar-tiny" src="{{ $item->user->avatar }}" />
    <strong>{{$item['title']}} </strong> <span class="text-muted small">
        @if (!isset($hideAuthor))
        by {{ $item->user->username}} 
        @endif
        on {{ $item['created_at']->format('m/d/Y ') }}</span>
</a>