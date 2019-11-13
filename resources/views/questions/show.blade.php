@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ $question->title }}</h1>
                            <div class="ml-auto">
                                <a href="{{ route('questions.index') }}" class="btn btn-outline-secondary">Back to All
                                    Questions</a>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="media">
                        <div class="d-fex flex-columns vote-controls">
                            <a title="This is a useful question" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1234</span>
                            <a title="This question is not usefull" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a title="Click to mark as favorite question(Click to undo)"
                                class="favorite mt-2 favorited">
                                <i class="fas fa-star fa-2x"></i>
                                <span class="favorites-count">123</span>
                            </a>
                            <a href=""></a>
                        </div>
                        <div class="media-body">
                            {!! $question->body_html !!}
                            <div class="float-right">
                                <span class="text-muted">{{ $question->created_date}}</span>
                                <div class="media mt-2">
                                    <a href="{{ $question->user->url}}" class="pr-2">
                                        <img src="{{ $question->user->avatar}}">
                                    </a>
                                    <div class="media-body mt-1">
                                        <a href="{{ $question->user->url }}">{{ $question->user->name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $question->answers_count ." ". Illuminate\Support\Str::plural('answer', $question->answers_count)}}
                        </h2>
                        <hr>
                    </div>
                    @foreach ($question->answers as $answer)
                    <div class="media">
                        <div class="d-fex flex-columns vote-controls">
                            <a title="This is a useful answer" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1234</span>
                            <a title="This answer is not usefull" class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            <a title="Mark as best answer" class="vote-accepted mt-2 ">
                                <i class="fas fa-check fa-2x"></i>
                            </a>
                            <a href=""></a>
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="float-right">
                                <span class="text-muted">{{ $answer->created_date}}</span>
                                <div class="media mt-2">
                                    <a href="{{ $answer->user->url}}" class="pr-2">
                                        <img src="{{ $answer->user->avatar}}">
                                    </a>
                                    <div class="media-body mt-1">
                                        <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection