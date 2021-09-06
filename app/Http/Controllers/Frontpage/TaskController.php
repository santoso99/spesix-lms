<?php

namespace App\Http\Controllers\Frontpage;

use App\Task;
use App\TaskSubmission;
use App\LearningTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function indexByTopic($topic_id)
    {
        return redirect('topics/'.$topic_id)->with('tasks', 'active show');
    }

    public function show(Task $task)
    {
        if(Auth::user()->roles[0]->name == "Siswa")
        {
            if($task->status == 0)
            {
                return redirect('topics/'.$task->learning_topic_id);
            }
        }

        $submission = TaskSubmission::whereTaskId($task->id)
                                        ->whereUserId(Auth::id())
                                        ->first();

        return view('frontpage.task.show', compact('task','submission'));
    }
}
