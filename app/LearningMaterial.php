<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    protected $fillable = ["name","file_path","content","learning_topic_id"];

    public function learningTopic()
    {
        return $this->belongsTo('App\LearningTopic');
    }
}
