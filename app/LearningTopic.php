<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LearningTopic extends Model
{
    protected $guarded = ['grade_id','competency_id'];

    public static function boot()
    {
        parent::boot();

        static::saving(function(){
            Cache::forget('topics');
            Cache::forget('recent_topics');
        });

        static::deleting(function(){
            Cache::forget('topics');
        });
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }

    public function getBasicCompetency()
    {
        $competencies = '';
        foreach($this->basicCompetencies as $competency)
        {
            $competencies .= $competency->competency.'<br>';
        }
        return $competencies;
    }

    public function scopeLast5($query)
    {
        return $query->orderBy('created_at')->take(5)->get();
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function learningMaterials()
    {
        return $this->hasMany('App\LearningMaterial');
    }

    public function visitors()
    {
        return $this->belongsToMany('App\User','learning_topic_visitor','learning_topic_id','user_id')->withTimestamps();
    }

    public function collectors()
    {
        return $this->belongsToMany('App\User','student_learning_topic','learning_topic_id','user_id')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany('App\Task')->with('learningTopic','user','subject');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Grade','learning_topic_grade','learning_topic_id','grade_id');
    }

    public function basicCompetencies()
    {
        return $this->belongsToMany('App\BasicCompetency','basic_competency_topic','learning_topic_id','basic_competency_id');
    }
}
