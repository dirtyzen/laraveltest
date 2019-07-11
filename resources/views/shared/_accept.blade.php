@can('accept', $model)
    <a
            title="Best Answer"
            class="mt-2 {{ $model->status }}"
            onclick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();"
    >
        <i class="fas fa-check fa-2x"></i>
    </a>

    <form id="accept-answer-{{ $model->id }}" action="{{ route('answers.accept', $model->id) }}" method="post" class="d-none">
        @csrf
    </form>
@else
    @if($model->is_best)
        <a title="The question owner accept this answer as best answer" class="mt-2 {{ $model->status }}">
            <i class="fas fa-check fa-2x"></i>
        </a>
    @endif
@endcan