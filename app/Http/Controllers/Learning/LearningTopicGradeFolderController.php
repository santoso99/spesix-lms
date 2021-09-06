<?php

namespace App\Http\Controllers\Learning;

use App\Subject;
use App\Grade;
use App\LearningTopic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearningTopicGradeFolderController extends Controller
{
    public function index()
    {
        $school_years = LearningTopic::distinct()->pluck('school_year');
        return view('admin.learning-topic.overview.index',compact('school_years'));
    }

    public function getGradeSemester(Request $request)
    {
        try {
            $school_year = $request->school_year;

            $view = view('admin.learning-topic.overview.grade-semester-folder-item', compact('school_year'))->render();

            return response()->json(['success' => true, 'content' => $view]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'e' => $th]);
        }
    }

    public function getGrade(Request $request)
    {
        try {
            $labels = Grade::where('grade_level', $request->grade_level)->select('id','name')->get()->toArray();
            $label_category = 'grade';
            $topic_data = [
                'school_year' => $request->school_year,
                'semester' => $request->semester,
            ];

            $view = view('admin.learning-topic.overview.folder-item', compact('labels','label_category','topic_data'))->render();

            return response()->json(['success' => true, 'content' => $view]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'e' => $th]);
        }
    }

    public function getSubject(Request $request)
    {
        try {
            $labels = Subject::select('id','name')->get()->toArray();
            $label_category = 'subject';
            $topic_data = [
                'school_year' => $request->school_year,
                'semester' => $request->semester,
                'grade_id' => $request->grade_id,
            ];

            $view = view('admin.learning-topic.overview.folder-item', compact('labels','label_category','topic_data'))->render();

            return response()->json(['success' => true, 'content' => $view]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'e' => $th]);
        }
    }

    public function getFilteredTopic(Request $request)
    {
        try {
            $grade = Grade::findOrFail($request->grade_id);

            $role = Auth::user()->roles[0]->name;

            if($role == "Pengajar")
            {
                $topics = $grade->learningTopics()
                                ->with(['subject','user','grades'])
                                // ->where('user_id',Auth::id())
                                ->where('school_year',$request->school_year)
                                ->where('semester',$request->semester)
                                ->where('subject_id',$request->subject_id)
                                ->get();
            }
            else {
                $topics = $grade->learningTopics()
                                ->with(['subject','user','grades'])
                                ->where('school_year',$request->school_year)
                                ->where('semester',$request->semester)
                                ->where('subject_id',$request->subject_id)
                                ->get();
            }

            $view = view('admin.learning-topic.overview.topic-table', compact('topics'))->render();

            return response()->json(['success' => true, 'content' => $view]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'e' => $th]);
        }
    }
}
