<?php

namespace App\Http\Controllers\Exam;

use App\ExamResponse;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamResponseController extends Controller
{
    public function index(ExamResult $exam_result)
    {
        if($exam_result->correction_status == 1)
        {
            return redirect('admin/exams/'.$exam_result->exam->id.'/results')->with('status', __('messages.correction_change_notice'));
        }

        $exam_questions = $exam_result->exam->questions;
        $exam_responses = $exam_result->examResponses;

        $exam_question_raw = \App\ExamQuestion::with('basicCompetency')->where('exam_id',$exam_result->exam_id)->orderBy('number')->get();

        return view('admin.exam-response.index', compact('exam_result','exam_questions','exam_responses','exam_question_raw'));
    }

    public function update(Request $request, ExamResult $exam_result, ExamResponse $exam_response)
    {
        $exam_response->update(['status' => $request->status, 'score' => $request->score, 'feedback' => $request->feedback]);
        $exam_score = $exam_result->score + $request->score;

        if($request->status == 1)
        {
            $total_correct_answer = $exam_result->total_correct_answer + 1;
            $exam_result->update(['total_correct_answer' => $total_correct_answer, 'score' => $exam_score]);
        }
        else {
            $total_wrong_answer = $exam_result->total_wrong_answer + 1;
            $exam_result->update(['total_wrong_answer' => $total_wrong_answer, 'score' => $exam_score]);
        }

        return redirect('student/exams/results/'.$exam_result->id.'/questions/'.$exam_response->question_id.'/next');
    }
}
