<?php

namespace App\Http\Controllers\FrontPage;

use App\LearningTopic;
use App\LearningPhase;
use App\LearningMaterial;
use App\Subject;
use App\Task;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningTopicController extends Controller
{

    public function show(LearningTopic $topic)
    {
        $this->record_visitor($topic);
        $views_count = $topic->visitors()->count();
        $author = (Auth::id() == $topic->user_id) ? true : false;
        
        $materials = $topic->learningMaterials;
        $tasks = null;
        $task_count = '-';
        
        if(Auth::check())
        {
            $grades = $topic->grades()->pluck('grades.id')->toArray();
            $user_grade = Auth::user()->grade_id;

            if(in_array($user_grade, $grades))
            {
                $tasks = Task::whereLearningTopicId($topic->id)->select('id','name','deadline','status')->get();
                $task_count = Task::whereLearningTopicId($topic->id)->count();
            }
        }
        
        return view('frontpage.learning-topic.show', compact('topic','materials','task_count','tasks','author','views_count'));
    }

    public function record_visitor(LearningTopic $topic)
    {
        if(Auth::check())
        {
            $topic->visitors()->syncWithoutDetaching(['user_id' => Auth::id()]);
        }
    }

}
