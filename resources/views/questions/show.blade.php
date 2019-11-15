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
                                <i class="fa fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1234</span>
                            <a title="This question is not usefull" class="vote-down off">
                                <i class="fa fa-caret-down fa-3x"></i>
                            </a>
                            <a title="Click to mark as favorite question(Click to undo)"
                                class="favorite mt-2 {{ Auth::guest() ? 'off' : ($question->is_favorited ? 'favorited' : '') }}"
                                onClick="event.preventDefault(); document.getElementById('favorite-question-{{ $question->id }}').submit();">
                                <i class="fa fa-star fa-2x"></i>
                                <span class="favorites-count">{{ $question->favorites_count }}</span>
                            </a>
                            <form action="/questions/{{ $question->id }}/favorites"
                                id="favorite-question-{{ $question->id }}" method="post" display="none">
                                @csrf
                                @if($question->is_favorited)
                                @method('DELETE')
                                @endif
                            </form>
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

    @include ('answers._index', [
    'answers' => $question->answers,
    'answersCount' => $question->answers_count,
    ])

    @include('answers._create')
</div>
@endsection