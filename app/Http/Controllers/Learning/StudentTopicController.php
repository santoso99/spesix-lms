<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\LearningTopic;
use Auth;
use App\Grade;

class StudentTopicController extends Controller
{
    public function index()
    {
        $topics = LearningTopic::with(['subject','user','grades'])->get();

        return view('student.learning-topic.index', compact('topics'));
    }

    public function indexMyTopic()
    {
        $topic_collection = Auth::user()->learningTopicCollections()->with('user','subject')->get();

        $topics_from_student_grade = Grade::findOrFail(Auth::user()->grade_id)->learningTopics()->with(['subject','user'])->get();

        $topics = $topic_collection->merge($topics_from_student_grade)->sortBy('grade_level');

        return view('student.learning-topic.index-my-topic', compact('topics'));
    }
}
