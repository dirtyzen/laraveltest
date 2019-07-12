<answer v-bind:answer="{{ $answer }}" inline-template>
    <div class="media post">

        @include("shared._votes", [
            'model' => $answer
        ])

        <div class="media-body">

            <form v-if="editing" @submit.prevent="update">

                <div class="form-group">
                    <textarea class="form-control" rows="10" v-model="body" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" :disabled="isInvalid">Update</button>
                <button type="button" class="btn btn-outline-secondary" @click="cancel">Cancel</button>

            </form>

            <div v-if="editing === false">

                <div v-html="bodyHtml"></div>

                {{--!! $answer->body_html !!--}}

                <div class="row">

                <div class="col-4">

                    @can('update', $answer)
                        <a @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                        {{--<a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>--}}
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

                    {{-- blade (php,html) version
                    @include("shared._author", [
                        'model' => $answer,
                        'label' => 'Answered'
                    ])
                    --}}


                    {{-- vue component version --}}
                    <user-info v-bind:model="{{ $answer }}" label="Answered"></user-info>

                </div>

            </div>
            </div>

        </div>

    </div>
</answer>