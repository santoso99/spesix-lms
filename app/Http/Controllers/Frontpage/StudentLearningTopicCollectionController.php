<?php

namespace App\Http\Controllers\Frontpage;

use App\LearningTopic;
use App\Grade;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentLearningTopicCollectionController extends Controller
{
    public function index()
    {
        $topic_collection = Auth::user()->learningTopicCollections()->with('user','subject')->get();

        $topics_from_student_grade = Grade::findOrFail(Auth::user()->grade_id)->learningTopics()->with(['subject','user'])->get();

        $topics = $topic_collection->merge($topics_from_student_grade)->sortBy('grade_level');

        return view('frontpage.learning-topic.collection.index', compact('topics'));
    }

    public function store(Request $request)
    {
        Auth::user()->learningTopicCollections()->syncWithoutDetaching(['learning_topic_id' => $request->topic_id]);

        return response()->json(['success' => true, 'message' => __('messages.topic_added')]);
    }

    public function destroy($topic)
    {
        Auth::user()->learningTopicCollections()->detach($topic);

        return response()->json(['success' => true, 'message' => __('messages.topic_removed')]);
    }
}
