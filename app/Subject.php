<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Subject extends Model
{
    protected $fillable = ['name'];

    public static function boot()
    {
        parent::boot();

        static::saving(function(){
            Cache::forget('subjects');
        });
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = ucwords($name);
    }

    public function learningTopics()
    {
        return $this->hasMany('App\LearningTopic');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }
}
