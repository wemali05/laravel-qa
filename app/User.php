<?php

namespace App;

use App\Answer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

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
    }
}
