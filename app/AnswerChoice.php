<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerChoice extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

    public function ExamResponses()
    {
        return $this->hasMany('App\ExamResponse');
    }
}
