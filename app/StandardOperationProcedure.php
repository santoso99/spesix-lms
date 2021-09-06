<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StandardOperationProcedure extends Model
{
    protected $fillable = ['user_id','file_path','filename'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
