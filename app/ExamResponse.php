<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResponse extends Model
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

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function answerChoice()
    {
        return $this->belongsTo('App\AnswerChoice');
    }

    public function examResult()
    {
        return $this->belongsTo('App\ExamResult');
    }

    public function basicCompetency()
    {
        return $this->belongsTo('App\BasicCompetency');
    }
}
