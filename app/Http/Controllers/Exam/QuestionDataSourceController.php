<?php

namespace App\Http\Controllers\Exam;

use App\Question;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class QuestionDataSourceController extends Controller
{
    public function fetchDataBySubject(Request $request, $exam, $subject)
    {
        if($request->ajax())
        {
            try {
                $exam_question_ids = DB::table('exam_question')->where('exam_id',$exam)->pluck('question_id')->toArray();

                $questions = Question::with('subject','user','questionType')->whereNotIn('id',$exam_question_ids)->where('user_id', Auth::id())->where('subject_id',$subject)->select('id','question_type_id','title','excerpt')->paginate(25);

                return view('admin.exam.question-bank-data', compact('questions'))->render();
            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
