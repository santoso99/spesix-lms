<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultipleChoiceResponse extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function answerChoice()
    {
        return $this->belongsTo('App\AnswerChoice');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }
}
