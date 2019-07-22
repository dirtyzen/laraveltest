@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title">
                            <div class="d-flex align-items-center">
                                <h2>{{ $question->title }}</h2>
                                <div class="ml-auto">
                                    <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back</a>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="media">

                            {{-- vue component version --}}
                            <vote :model="{{ $question }}" name="question"></vote>

                            {{-- blade (php,html) version
                            @include("shared._votes", [
                                'model' => $question
                            ])
                            --}}

                            <div class="media-body">
                                {!! $question->body_html !!}

                                <div class="row">
                                    <div class="col-4"></div>
                                    <div class="col-4"></div>
                                    <div class="col-4">

                                        {{-- blade (php,html,css) version
                                        @include("shared._author", [
                                          'model' => $question,
                                          'label' => 'Asked'
                                        ])
                                        --}}

                                        {{-- vue component version --}}
                                        <user-info v-bind:model="{{ $question }}" label="Asked"></user-info>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{--
        blade (php,html) version
        getting answers field
        @include("answers._index", [
            'answersCount' => $question->answers_count,
            'answers' => $question->answers
        ])
        --}}

        {{-- vue component version --}}
        <answers :question="{{ $question }}"></answers>


        {{-- getting answer form field --}}
        @if(Auth::user())
            @include("answers._create")
        @endif

    </div>
@endsection
