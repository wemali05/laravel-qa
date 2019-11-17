   <a title="Click to mark as favorite question(Click to undo)"
       class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
       onClick="event.preventDefault(); document.getElementById('favorite-question-{{ $model->id }}').submit();">
       <i class="fa fa-star fa-2x"></i>
       <span class="favorites-count">{{ $model->favorites_count }}</span>
   </a>
   <form action="/questions/{{ $model->id }}/favorites" id="favorite-question-{{ $model->id }}" method="post"
       display="none">
       @csrf
       @if($question->is_favorited)
       @method('DELETE')
       @endif
   </form>