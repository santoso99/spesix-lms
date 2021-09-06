<?php

namespace App\Http\Controllers\Parent;

use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentExamController extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->student->id;
        $exam_results = ExamResult::with('exam')->where('user_id',$user_id)->get();

        return view('student.exam-result.index', compact('exam_results'));
    }

    public function show(ExamResult $exam_result)
    {
        if($exam_result->exam->status == 1)
        {
            return redirect('student/exams')->with('status',__('messages.exam_result_unaccessed'));
        }

        $exam_questions = $exam_result->exam->questions;
        $exam_responses = $exam_result->examResponses;

        return view('student.exam-result.show', compact('exam_result','exam_questions','exam_responses'));
    }
}
