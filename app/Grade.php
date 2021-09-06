<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Grade extends Model
{

    public static function boot()
    {
        parent::boot();

        static::saving(function(){
            Cache::forget('grades');
        });
    }

    protected $fillable = [
        'name',
        'grade_level',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function exams()
    {
        return $this->belongsToMany('App\Exam');
    }

    public function learningTopics()
    {
        return $this->belongsToMany('App\LearningTopic','learning_topic_grade','grade_id','learning_topic_id');
    }
}
