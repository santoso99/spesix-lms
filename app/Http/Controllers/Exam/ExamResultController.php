<?php

namespace App\Http\Controllers\Exam;

use App\Grade;
use App\Exam;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamResultController extends Controller
{
    public function index(Exam $exam)
    {
        $exam_results = DB::table('exam_results')
                            ->join('users','exam_results.user_id','=','users.id')
                            ->join('grades','users.grade_id','=','grades.id')
                            ->where('exam_id',$exam->id)
                            ->select('exam_results.*','users.name as user','grades.name as grade')
                            ->get();
        $grades = $exam->grades->sort();

        $exam_result_count = DB::table('exam_results')
                        ->where('exam_id', $exam->id)
                        ->selectRaw("count(case when exam_results.is_remedial = 1 then 1 end) as studentFail")
                        ->selectRaw("count(case when exam_results.is_remedial = 0 then 1 end) as studentPass")
                        ->selectRaw("avg(exam_results.final_score) as averageScore")
                        ->first();

        return view('admin.exam-result.index', compact('exam','exam_results','grades','exam_result_count'));
    }

    public function indexByGrade(Exam $exam, Grade $grade)
    {
        $exam_results = DB::table('exam_results')
                            ->join('users','exam_results.user_id','=','users.id')
                            ->join('grades','users.grade_id','=','grades.id')
                            ->where('users.grade_id', $grade->id)
                            ->where('exam_results.exam_id', $exam->id)
                            ->select('exam_results.*','users.name as user','grades.name as grade')
                            ->get();
        $grades = $exam->grades->sort();

        $exam_result_count = DB::table('exam_results')
                        ->join('users','exam_results.user_id','=','users.id')
                        ->where('users.grade_id', $grade->id)
                        ->where('exam_results.exam_id', $exam->id)
                        ->selectRaw("count(case when exam_results.is_remedial = 1 then 1 end) as studentFail")
                        ->selectRaw("count(case when exam_results.is_remedial = 0 then 1 end) as studentPass")
                        ->selectRaw("avg(exam_results.final_score) as averageScore")
                        ->first();

        return view('admin.exam-result.index', compact('exam','exam_results','grades','exam_result_count'));
    }
    
    public function destroy(Request $request, $exam)
    {
        $exam_result_ids = $request->exam_result_id;

        if($exam_result_ids == null){
            return back();
        }

        ExamResult::whereIn('id', $exam_result_ids)->delete();

        return redirect('admin/exams/'.$exam.'/results')->with('status', __('messages.exam_result_deleted'));
    }

    public function showStudentsResponse(Exam $exam)
    {
        $exam_questions = $exam->questions;
        $exam_results = ExamResult::with('user')->where('exam_id',$exam->id)->get();
        $grades = $exam->grades;

        return view('admin.exam-result.show', compact('exam','exam_questions','exam_results','grades'));
    }

    public function showStudentsResponseByGrade(Exam $exam, Grade $grade)
    {
        // $exam_questions = $exam->question;
        // $exam_responses = $exam->examResponses;

        // return view('admin.exam-result.show', compact('exam','exam_questions','exam_responses'));
    }
}
