<?php

namespace App\Http\Controllers\Frontpage;

use App\ExamResult;
use App\Exam;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamResultController extends Controller
{
    public function create(Exam $exam)
    {
        if($exam->status == 0)
        {
            return redirect('exams')->with('status', __('messages.eval_finish'));
        }
        
        $user = Auth::user();

        if(!$exam->grades->contains('id',$user->grade_id))
        {
            if($user->grade == null)
            {
                $forbidden_msg = __('messages.evaluation_student_only');
            }
            else {
                $forbidden_msg = __('messages.evaluation_student_class_only', ['grade' => $user->grade->name]);
            }
            
            return view('frontpage.exam.unlock', compact('exam','forbidden_msg'));
        }

        $exam_result = ExamResult::where('user_id',$user->id)->where('exam_id',$exam->id)->first();

        if(!$exam_result)
        {
            return view('frontpage.exam.unlock', compact('exam'));
        }

        return redirect('exams/'.$exam->id);
    }

    public function store(Request $request, Exam $exam)
    {
        if($exam->status == 0)
        {
            return redirect('exams')->with('status', __('messages.eval_finish'));
        }

        if($request->enroll_code != $exam->enroll_code)
        {
            $error = __('messages.invalid_code_access');
            return view('frontpage.exam.unlock', compact('exam','error'));
        }

        $grades = $exam->grades()->pluck('grades.id')->toArray();
        $user_grade = Auth::user()->grade_id;

        if(!in_array($user_grade, $grades))
        {
            $error = __('messages.student_class_disallowed');
            return view('frontpage.exam.unlock', compact('exam','error'));
        }

        $user_id = Auth::id();
        ExamResult::updateOrCreate(['user_id' => $user_id, 'exam_id' => $exam->id]);

        $exam_questions = $exam->questions;
        $total_question_answered = 0;
        
        return redirect('exams/'.$exam->id);
    }
}
