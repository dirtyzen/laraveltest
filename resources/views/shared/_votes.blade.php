@if($model instanceof  App\Question)
    @php
        $name = 'question';
        $firstURISegment = 'questions';
    @endphp
@elseif($model instanceof  App\Answer)
    @php
        $name = 'answer';
        $firstURISegment = 'answers';
    @endphp
@endif


@php
    $formId = $name ."-". $model->id;
    $formAction = "/{$firstURISegment}/{$model->id}/vote";
@endphp

<div class="d-flex flex-column vote-controls">

    <a
            title="Vote Up"
            class="vote-up {{ Auth::guest() ? 'off' : '' }}"
            onclick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-up fa-3x"></i>
    </a>

    <form id="up-vote-{{ $formId }}" action="{{ $formAction }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>

    <span class="vote-count">{{ $model->votes_count }}</span>

    <a
            title="Vote Down"
            class="vote-down {{ Auth::guest() ? 'off' : '' }}"
            onclick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();"
    >
        <i class="fas fa-caret-down fa-3x"></i>
    </a>

    <form id="down-vote-{{ $formId }}" action="{{ $formAction }}" method="post" class="d-none">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>

    @if($model instanceof App\Question)

        {{-- vue component version --}}
        <favorite :question="{{ $model }}"></favorite>

        {{-- blade (php,html) version
        @include("shared._favorite", [
            'model' => $model
        ])
        --}}

    @elseif($model instanceof App\Answer)

        {{-- vue component version --}}
        <accepted :answer="{{ $model }}"></accepted>

        {{-- blade (php,html) version
        @include("shared._accept", [
            'model' => $model
        ])
        --}}

    @endif

</div>