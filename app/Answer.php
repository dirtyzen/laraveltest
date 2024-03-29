<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    use VotableTrait;

    protected $fillable = ['body', 'user_id'];

    protected $appends = ['body_html', 'is_best', 'created_date'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return clean(\Parsedown::instance()->setBreaksEnabled(true)->setMarkupEscaped(true)->text(strip_tags($this->body)));
    }

    public static function boot()
    {

        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer){
            $answer->question->decrement('answers_count');
        });


//        static::saved(function($answer){
//            echo 'answer saved';
//        });

    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {
        return $this->isBest() ? 'vote-accepted' : '';
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    public function isBest()
    {
        return $this->id === $this->question->best_answer_id;
    }



}
