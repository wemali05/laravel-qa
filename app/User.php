<?php

namespace App;

use App\Answer;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['url', 'avatar'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function favorites()
    {
        return $this->belongstoMany(Question::class, 'favorites')->withTimestamps();//$question->id, $user->id
    }

    public function posts()
    {
        $type = request()->get('type');
        if ($type === 'questions') {
            $posts = $this->questions()->get();
        } else {
            $posts = $this->answers()->with('question')->get();
            if ($type !== 'answers') {
                $posts2 = $this->questions()->get();
                $posts = $posts->merge($posts2);
            }
        }
        $data = collect();
        foreach ($posts as $post) {
            $item = [
                'votes_count' => $post->votes_count,
                'created_at' => $post->created_at->format('M d Y')
            ];
            if ($post instanceof Answer) {
                $item['type'] = 'A';
                $item['title'] = optional($post->question)->title;
                $item['accepted'] =optional($post->question)->best_answer_id === $post->id ? true : false;
            } elseif ($post instanceof Question) {
                $item['type'] = 'Q';
                $item['title'] = $post->title;
                $item['accepted'] = (bool) $post->best_answer_id;
            }
            $data->push($item);
        }
        return $data->sortByDesc('votes_count')->values()->all();
    }
   
    public function getUrlAttribute()
    {
        // return route('question.show', $this->id);
        return '#';
    }


    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return  "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable');
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable');
    }

    public function voteQuestion(Question $question, $vote)
    {
        $voteQuestion = $this->voteQuestions();
        if ($voteQuestion->where('votable_id', $question->id)->exists()) {
            $voteQuestion->updateExistingPivot($question, ['vote' => $vote]);
        } else {
            $voteQuestion->attach($question, ['vote' => $vote]);
        }

        $question->load('votes');
        $downVote = (int) $question->downVotes()->sum('vote');
        $upVote = (int) $question->upVotes()->sum('vote');

        $question->votes_count = $upVote + $downVote;
        $question->save();

        return $question->votes_count;
    }

    public function voteAnswer(Answer $answer, $vote)
    {
        $voteAnswer = $this->voteAnswers();
        if ($voteAnswer->where('votable_id', $answer->id)->exists()) {
            $voteAnswer->updateExistingPivot($answer, ['vote' => $vote]);
        } else {
            $voteAnswer->attach($answer, ['vote' => $vote]);
        }

        $answer->load('votes');
        $downVote = (int) $answer->downVotes()->sum('vote');
        $upVote = (int) $answer->upVotes()->sum('vote');

        $answer->votes_count = $upVote + $downVote;
        $answer->save();

        return $answer->votes_count;
    }
}
