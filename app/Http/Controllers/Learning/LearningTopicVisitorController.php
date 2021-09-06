<?php

namespace App\Http\Controllers\Learning;

use App\LearningTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LearningTopicVisitorController extends Controller
{
    public function index(LearningTopic $topic)
    {
        return view('admin.learning-topic.visitor', compact('topic'));
    }
}
