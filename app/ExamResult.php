<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function examResponses()
    {
        return $this->hasMany('App\ExamResponse');
    }
}
