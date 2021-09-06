<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TaskSubmission extends Model
{
    protected $fillable = ['task_id','user_id','submission_path','submission_filename','status','teacher_notes','mark'];

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->format('d F Y H:i');
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        if($updated_at == null)
        {
            return $updated_at;
        }
        return Carbon::parse($updated_at)->format('d F Y H:i');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
