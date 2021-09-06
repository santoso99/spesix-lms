<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LearningPhase extends Model
{
    protected $fillable = ["title","learning_topic_id"];

    public function learningTopic()
    {
        return $this->belongsTo('App\LearningTopic');
    }

    public function learningMaterials()
    {
        return $this->hasMany('App\LearningMaterial');
    }
}
