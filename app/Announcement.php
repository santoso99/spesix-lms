<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class Announcement extends Model
{
    protected $fillable = ['title', 'user_id', 'excerpt', 'content', 'date', 'start_time'];

    public function setTitleAttribute($title)
    {
        $this->attributes['title'] = ucwords($title);
    }

    public function setExcerptAttribute($content)
    {
        $this->attributes['excerpt'] = Str::words($content, 35, '...');
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = Carbon::createFromFormat('l d F Y', $date);
    }

    public function setStartTimeAttribute($start_time)
    {
        $this->attributes['start_time'] = Carbon::parse($start_time)->format('H:i:s');
    }

    public function getStartAttribute()
    {
        return "{$this->date}T{$this->start_time}";
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('l d F Y');
    }

    public function getFormattedStartTimeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i')." WIB";
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
