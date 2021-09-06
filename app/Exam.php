<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Exam extends Model
{
    protected $guarded = [];
    protected $dates = ['date'];

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('l d F Y', $date);
    }

    public function setTimeStartAttribute($time_start)
    {
        $this->attributes['time_start'] = Carbon::parse($time_start)->format('H:i:s');
    }

    public function setTimeEndAttribute($time_end)
    {
        $this->attributes['time_end'] = Carbon::parse($time_end)->format('H:i:s');
    }

    public function getTimeStartAttribute($time_start)
    {
        return Carbon::parse($time_start)->format('H:i');
    }

    public function getTimeEndAttribute($time_end)
    {
        return Carbon::parse($time_end)->format('H:i');
    }

    public function getDateAttribute($date)
    {
        return Carbon::parse($date);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
    
    public function multipleChoiceResponses()
    {
        return $this->hasMany('App\MultipleChoiceResponse');
    }

    public function essayResponse()
    {
        return $this->hasMany('App\EssayResponse');
    }

    public function examResults()
    {
        return $this->hasMany('App\ExamResult')->with('user');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question')->withPivot('id','number','basic_competency_id')->with(['examResponses.answerChoice']);
    }

    public function examResponses()
    {
        return $this->hasMany('App\ExamResponse');
    }

    public function grades()
    {
        return $this->belongsToMany('App\Grade');
    }
}
