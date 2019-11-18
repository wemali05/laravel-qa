<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [ 'title', 'body' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //$question->id, $user->id
    }

    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count()>0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }


    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getUrlAttribute()
    {
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return 'accepted-answer';
            }
            return 'answered';
        }
        return 'unaswered';
    }

    // public function setBodyHtmlAttributes($value)
    // {
    //     $this->attributes['body'] = clean($value);
    // }

    public function getBodyHtmlAttribute()
    {
        return clean($this->htmlBody());
    }

    public function acceptBestAnswer(Answer $answer)
    {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function upVotes()
    {
        return  $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }

    public function getExceptAttribute()
    {
        return $this->excerpt(250);
    }
    public function excerpt($length)
    {
        return str_limit(strip_tags($this->htmlBody()), $length);
    }
    private function htmlBody()
    {
        return \Parsedown::instance()->text($this->body);
    }
}
