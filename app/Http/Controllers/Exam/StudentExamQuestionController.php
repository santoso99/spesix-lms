<?php

namespace App\Http\Controllers\Exam;

use App\Question;
use App\Exam;
use App\ExamResponse;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentExamQuestionController extends Controller
{
    public function show(ExamResult $exam_result, Question $question)
    {
        if($exam_result->exam->status == 1)
        {
            return redirect('student/exams/results/'.$exam_result->id)->with('status', __('messages.review_answer_wait_notice'));
        }

        $exam_response = $exam_result->examResponses->where('question_id',$question->id)->first();

        $number = $exam_result->exam->questions->find($question->id)->pivot->number;

        return view('student.exam-result.question-show', compact('exam_result','question','exam_response','number'));
    }

    public function showPrevious(ExamResult $exam_result, Question $question)
    {
        if($exam_result->exam->status == 0)
        {
            return redirect('student/exams/results/'.$exam_result->id)->with('status', __('messages.review_answer_wait_notice'));
        }

        $number = $exam_result->exam->questions->find($question->id)->pivot->number;

        if($number == 1)
        {
            if(Auth::user()->hasrole('Siswa')){
                return redirect('student/exams/results/'.$exam_result->id);
            }
            elseif(Auth::user()->hasrole('Pengajar'))
            {
                return redirect('admin/exams/results/'.$exam_result->id.'/responses');
            }
        }

        $number = $number-1;
        $prev_question_id = DB::table('exam_question')->where('number',$number)->first()->question_id;
        $question = Question::findOrFail($prev_question_id);

        $exam_response = $exam_result->examResponses->where('question_id',$question->id)->first();

        return view('student.exam-result.question-show', compact('exam_result','question','exam_response','number'));
    }

    public function showNext(ExamResult $exam_result, Question $question)
    {
        if($exam_result->exam->status == 0)
        {
            return redirect('student/exams/results/'.$exam_result->id)->with('status', __('messages.review_answer_wait_notice'));
        }

        $number = $exam_result->exam->questions->find($question->id)->pivot->number;

        if($number == $exam_result->exam->total_question)
        {
            if(Auth::user()->hasrole('Siswa')){
                return redirect('student/exams/results/'.$exam_result->id);
            }
            elseif(Auth::user()->hasrole('Pengajar'))
            {
                return redirect('admin/exams/results/'.$exam_result->id.'/responses');
            }
        }

        $number = $number+1;
        $next_question_id = DB::table('exam_question')->where('number',$number)->first()->question_id;
        $question = Question::findOrFail($next_question_id);
        
        $exam_response = $exam_result->examResponses->where('question_id',$question->id)->first();

        return view('student.exam-result.question-show', compact('exam_result','question','exam_response','number'));
    }
}
