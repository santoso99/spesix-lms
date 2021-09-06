<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    protected $fillable = ['name','instruction','deadline','status','attachment_path','attachment_filename','learning_topic_id','user_id','subject_id'];

    protected $dates = ['deadline'];

    public function setDeadlineAttribute($deadline)
    {
        $this->attributes['deadline'] = Carbon::createFromFormat('l d F Y - H:i', $deadline);
    }

    public function getDeadlineAttribute($deadline)
    {
        return Carbon::parse($deadline)->format('l d F Y - H:i');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('d F Y');
    }

    public function learningTopic()
    {
        return $this->belongsTo('App\LearningTopic');
    }

    public function taskSubmissions()
    {
        return $this->hasMany('App\TaskSubmission');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
}
