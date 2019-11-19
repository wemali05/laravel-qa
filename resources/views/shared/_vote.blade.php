@if($model instanceof App\Question)
@php
$name = 'question';
$firstURISegment = 'questions';
@endphp
@elseif($model instanceof App\Answer)
@php
$name = 'answer';
$firstURISegment = 'answers';
@endphp
@endif

@php
$formId = $name . "-" .$model->id;
$formAction = "/{$firstURISegment}/{$model->id}/vote";
@endphp

<div class="d-fex flex-columns vote-controls">
    <a title="This is a useful {{ $name }}" class="vote-up {{ Auth::guest() ? 'off' : ''}}"
        onClick="event.preventDefault(); document.getElementById('up-vote-{{ $formId }}').submit();">
        <i class="fa fa-caret-up fa-3x"></i>
    </a>
    <form action="{{ $formAction }}" id="up-vote-{{ $formId }}" method="post" display="none">
        @csrf
        <input type="hidden" name="vote" value="1">
    </form>
    <span class="votes-count">{{ $model->votes_count}}</span>
    <a title="This {{ $name }} is not usefull" class="vote-down off {{ Auth::guest() ? 'off' : ''}}"
        onClick="event.preventDefault(); document.getElementById('down-vote-{{ $formId }}').submit();">
        <i class="fa fa-caret-down fa-3x"></i>
    </a>
    <form action="{{ $formAction }}" id="down-vote-{{ $formId }}" method="post" display="none">
        @csrf
        <input type="hidden" name="vote" value="-1">
    </form>
    @if($model instanceof App\Question)
    <favorite :question="{{ $model }}"></favorite>
    @elseif($model instanceof App\Answer)
    @include('shared._accept', [
    'model' => $model
    ])
    @endif
    <a href=""></a>
</div>