<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    public static function boot()
    {
        parent::boot();

        static::saving(function(){
            Cache::forget('members');
            Cache::forget('students');
            Cache::forget('teachers');
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade_id','member_id','name', 'email', 'password','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($password)
    {
        if(trim($password) === ''){
            return;
        }

        $this->attributes['password'] = Hash::make($password);
    }

    public function grade()
    {
        return $this->belongsTo('App\Grade');
    }

    public function member()
    {
        return $this->belongsTo('App\Member');
    }

    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }

    public function learningTopics()
    {
        return $this->hasMany('App\LearningTopic');
    }

    public function learningTopicViews()
    {
        return $this->belongsToMany('App\LearningTopic','learning_topic_visitor','user_id','learning_topic_id')->withTimestamps();
    }

    public function learningTopicCollections()
    {
        return $this->belongsToMany('App\LearningTopic','student_learning_topic','user_id','learning_topic_id')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function taskSubmissions()
    {
        return $this->hasMany('App\TaskSubmission');
    }

    public function standardOperationProcedures()
    {
        return $this->hasMany('App\StandardOperationProcedure');
    }

    public function questions()
    {
        return $this->hasMany('App\Question');
    }

    public function multipleChoiceResponses()
    {
        return $this->hasMany('App\MultipleChoiceResponse');
    }

    public function essayResponses()
    {
        return $this->hasMany('App\EssayResponse');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam');
    }

    public function examResults()
    {
        return $this->hasMany('App\ExamResult');
    }

    public function examResponses()
    {
        return $this->hasMany('App\ExamResponse');
    }

    public function student()
    {
        return $this->belongsTo(self::class, 'student_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(self::class, 'student_id', 'id');
    }

}
