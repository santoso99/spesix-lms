<?php

namespace App\Http\Controllers\Frontpage;

use App\Exam;
use App\ExamResponse;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('subject','user')->where('status',1)->get();

        return view('frontpage.exam.index', compact('exams'));
    }

    public function show(Exam $exam)
    {
        if($exam->status == 0)
        {
            return redirect('exams/'.$exam->id.'/finish');
        }

        $user_id = Auth::id();

        $exam_questions = $exam->questions;

        $exam_responses = ExamResponse::with('answerChoice')->where('user_id',$user_id)
                                                            ->where('exam_id',$exam->id)
                                                            ->get();

        $total_answered_question = $exam_responses->count();

        return view('frontpage.exam.show',compact('exam','exam_questions','exam_responses','total_answered_question'));
    }

    public function start(Exam $exam)
    {
        if($exam->status == 0)
        {
            return redirect('exams/'.$exam->id.'/finish');
        }

        $user_id = Auth::id();
        
        $question = $exam->questions->first();
        $exam_response = ExamResponse::where('user_id',$user_id)
                                        ->where('exam_id',$exam->id)
                                        ->where('question_id',$question->id)->first();
        
        $number = $exam->questions->find($question->id)->pivot->number;
        $competency_id = \App\ExamQuestion::where('exam_id',$exam->id)->where('question_id',$question->id)->first()->basic_competency_id;

        return view('frontpage.exam.question-show', compact('exam','question','exam_response','number','competency_id'));
    }

    public function finish(Exam $exam)
    {
        $user_id = Auth::id();

        $exam_result = ExamResult::where('user_id',$user_id)->where('exam_id',$exam->id)->first();

        $score = $exam_result->examResponses->sum('score');
        $total_answered_question = $exam_result->examResponses->count();
        $total_correct_answer = $exam_result->examResponses->where('status',1)->count();
        $total_wrong_answer = $exam->total_question - $total_correct_answer;

        $is_remedial = ($score < $exam->kkm_score) ? 1 : 0;

        $exam_result->update([
            'score' => $score,
            'is_remedial' => $is_remedial,
            'final_score' => $score,
            'total_answered_question' => $total_answered_question,
            'total_correct_answer' => $total_correct_answer,
            'total_wrong_answer' => $total_wrong_answer
        ]);

        $exam_finish = true;

        return view('frontpage.exam.result', compact('exam','total_answered_question','exam_finish'));
    }
}
