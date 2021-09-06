<?php

namespace App\Http\Controllers\Frontpage;

use App\LearningTopic;
use App\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class LearningTopicIndexController extends Controller
{
    public function index()
    {
        Cache::forget('topics');

        $topics = Cache::remember('topics', config('cache.duration.short'), function(){
            return LearningTopic::with(['user','subject','basicCompetencies'])->orderBy('grade_level')->get();
        });

        return view('frontpage.learning-topic.index', compact('topics'));
    }

    public function indexByGrade($grade_level)
    {
        $topics = LearningTopic::with('user','subject','basicCompetencies')->where('grade_level',$grade_level)->get();

        return view('frontpage.learning-topic.index', compact('topics','grade_level'));
    }

    public function indexBySubject(Subject $subject)
    {
        $topics = LearningTopic::with('user','subject','basicCompetencies')->where('subject_id',$subject->id)->get();
        $subject_name = $subject->name;

        return view('frontpage.learning-topic.index', compact('topics', 'subject_name'));
    }

    public function indexByGradeSubject($grade_level, Subject $subject)
    {
        $topics = LearningTopic::with('user','subject','basicCompetencies')->where('grade_level',$grade_level)->where('subject_id',$subject->id)->get();
        $subject_name = $subject->name;

        return view('frontpage.learning-topic.index', compact('topics','grade_level','subject_name'));
    }

    public function indexBySubjectSchoolYear(Request $request)
    {
        $topics = LearningTopic::with('user','subject','basicCompetencies')->where('school_year',$request->school_year)->where('subject_id',$request->subject_id)->get();
        $subject_name = Subject::find($request->subject_id)->name;
        $school_year = $request->school_year;

        return view('frontpage.learning-topic.index', compact('topics','subject_name','school_year'));
    }
}
