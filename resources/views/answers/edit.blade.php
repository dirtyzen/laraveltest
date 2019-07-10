@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Question: {{ $question->title }}</h2>
                            <div class="ml-auto">
                                <a href="{{ route('questions.show', $question->slug) }}" class="btn btn-outline-secondary">Back</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <form action="{{ route('questions.answers.update', [$question->id, $answer->id]) }}" method="post" enctype="multipart/form-data">

                            @csrf
                            @method('PATCH')

                            <div class="form-group">
                                <textarea name="body" rows="7" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}">{{ old('body', $answer->body) }}</textarea>
                                @if($errors->has('body'))
                                    <div class="invalid-feedback">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-lg btn-outline-primary">Submit For Update</button>
                            </div>

                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
