<div class="card mb-3">
    <div class="card-header d-flex justify-content-between p-0">
        <div class="p-2">
        <a href="/profiles/{{ $reply->owner->name }}">
                {{ $reply->owner->name }}
            </a> 
            said {{ $reply->created_at->diffForHumans() }}...
        </div>
        <div class="p-2">
            <form method="POST" action="/replies/{{ $reply->id }}/favorites">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-primary btn-sm" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}
                </button>
            </form>
        </div>
    </div>
    
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>