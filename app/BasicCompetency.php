<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BasicCompetency extends Model
{
    protected $guarded = [];

    public function learningTopics()
    {
        return $this->belongsToMany('App\LearningTopic','basic_competency_topic','basic_competency_id','learning_topic_id');
    }

    public function examQuestions()
    {
        return $this->hasMany('App\ExamQuestion');
    }

    public function examResponses()
    {
        return $this->hasMany('App\ExamQuestion');
    }
}
