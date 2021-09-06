<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Member extends Model
{
    protected $fillable = [
        'identity_number',
        'name',
        'grade',
        'pob',
        'is_account_created',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function(){
            Cache::forget('members');
            Cache::forget('students');
            Cache::forget('teachers');
        });
    }

    public function setPobAttribute($pob)
    {
        $this->attributes['pob'] = strtoupper($pob);
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
