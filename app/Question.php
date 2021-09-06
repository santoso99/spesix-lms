<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $guarded = [];

    public function setExcerptAttribute($question)
    {
        $this->attributes['excerpt'] = Str::limit(strip_tags($question), 150, '...');
    }

    public function questionType()
    {
        return $this->belongsTo('App\QuestionType');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function answerChoices()
    {
        return $this->hasMany('App\AnswerChoice');
    }

    public function multipleChoiceResponses()
    {
        return $this->hasMany('App\MultipleChoiceResponse');
    }

    public function essayResponses()
    {
        return $this->hasMany('App\EssayResponse');
    }

    public function exams()
    {
        return $this->belongsToMany('App\Exam')->withPivot('id','number','basic_competency_id');
    }

    public function examResponses()
    {
        return $this->hasMany('App\ExamResponse');
    }
}
