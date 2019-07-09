<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

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
        return \Parsedown::instance()->setBreaksEnabled(true)->setMarkupEscaped(true)->text($this->body);
    }

    public static function boot()
    {

        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });


//        static::saved(function($answer){
//            echo 'answer saved';
//        });

    }

}
