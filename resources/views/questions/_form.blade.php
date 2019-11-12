@csrf
<div class="form-group">
    <label for="question-title">Question Title</label>
    <input type="text" name="title" value="{{ old('title', $question->title) }}"
        class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}" id="question-title">

    @if($errors->has('title'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('title') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <label for="question-body">Describe Your question</label>
    <textarea name="body" id="question-body" class="form-control {{ $errors->has('body') ? 'is-invalid' : ''}}"
        cols="30" rows="10">{{ old('body', $question->body) }}</textarea>

    @if($errors->has('body'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('body') }}</strong>
    </div>
    @endif
</div>
<div class="form-group">
    <button class="btn btn-outline-primary btn-lg">{{ $buttonText }}</button>
</div>