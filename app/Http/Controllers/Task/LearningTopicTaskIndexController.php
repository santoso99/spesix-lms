<?php

namespace App\Http\Controllers\Task;

use App\Task;
use App\LearningTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LearningTopicTaskIndexController extends Controller
{

    public function __invoke(LearningTopic $topic)
    {
        $tasks = $topic->tasks;

        return view('admin.task.index', compact('tasks','topic'));
    }
}
