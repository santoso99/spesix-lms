<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'exam_question';
    protected $guarded = [];

    public function basicCompetency()
    {
        return $this->belongsTo('App\BasicCompetency');
    }
}
