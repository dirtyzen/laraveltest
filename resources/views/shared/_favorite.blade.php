<a
        title="Favorite"
        class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
        onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit();"
>
    <i class="fas fa-star fa-2x"></i>
    <span class="favorite-count">{{ $model->favorites_count }}</span>
</a>

<form id="favorite-question-{{ $model->id }}" action="/questions/{{ $model->id }}/favorites" method="post" class="d-none">
    @csrf
    @if($model->is_favorited)
        @method('DELETE')
    @endif
</form>