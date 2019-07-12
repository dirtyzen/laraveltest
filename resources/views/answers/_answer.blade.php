<div class="media post">

    @include("shared._votes", [
        'model' => $answer
    ])

    <div class="media-body">
        {!! $answer->body_html !!}

        <div class="row">

            <div class="col-4">

                @can('update', $answer)
                    <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                @endcan

                @can('delete', $answer)
                    <form class="form-delete" action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="post" enctype="multipart/form-data">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                @endcan

            </div>

            <div class="col-4"></div>

            <div class="col-4">
                @include("shared._author", [
                    'model' => $answer,
                    'label' => 'Answered'
                ])
            </div>

        </div>



    </div>
</div>