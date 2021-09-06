<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EssayResponse extends Model
{
    protected $guarded = ['score'];

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
}
