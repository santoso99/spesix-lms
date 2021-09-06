<?php

namespace App\Http\Controllers\Frontpage;

use App\Exam;
use App\Question;
use App\AnswerChoice;
use App\ExamResponse;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamQuestionController extends Controller
{
    public function show(Exam $exam, Question $question)
    {
        if($exam->status == 0)
        {
            return redirect('exams/'.$exam->id.'/finish');
        }

        $user_id = Auth::id();
        $exam_response = ExamResponse::where('user_id',$user_id)
                                        ->where('exam_id',$exam->id)
                                        ->where('question_id',$question->id)->first();
        
        $number = $exam->questions->find($question->id)->pivot->number;
        // $competency_id = $exam->questions->find($question)->pivot->basic_competency_id;
        $competency_id = \App\ExamQuestion::where('exam_id',$exam->id)->where('question_id',$question->id)->first()->basic_competency_id;

        return view('frontpage.exam.question-show', compact('exam','question','exam_response','number','competency_id'));
    }

    public function showPrevious(Exam $exam, Question $question)
    {
        if($exam->status == 0)
        {
            return redirect('exams/'.$exam->id.'/finish');
        }

        $number = $exam->questions->find($question->id)->pivot->number;

        if($number == 1)
        {
            return redirect('exams/'.$exam->id);
        }

        $number = $number-1;
        $prev_question_id = DB::table('exam_question')->where('exam_id',$exam->id)->where('number',$number)->first()->question_id;
        $question = Question::findOrFail($prev_question_id);

        $user_id = Auth::id();
        $exam_response = ExamResponse::where('user_id',$user_id)
                                        ->where('exam_id',$exam->id)
                                        ->where('question_id',$question->id)->first();

        $competency_id = \App\ExamQuestion::where('exam_id',$exam->id)->where('question_id',$question->id)->first()->basic_competency_id;

        return view('frontpage.exam.question-show', compact('exam','question','exam_response','number','competency_id'));
    }

    public function showNext(Exam $exam, Question $question)
    {
        if($exam->status == 0)
        {
            return redirect('exams/'.$exam->id.'/finish');
        }
        
        $number = $exam->questions->find($question->id)->pivot->number;

        if($number == $exam->total_question)
        {
            return redirect('exams/'.$exam->id);
        }

        $number = $number+1;
        $next_question_id = DB::table('exam_question')->where('exam_id',$exam->id)->where('number',$number)->first()->question_id;
        $question = Question::findOrFail($next_question_id);

        $user_id = Auth::id();
        $exam_response = ExamResponse::where('user_id',$user_id)
                                        ->where('exam_id',$exam->id)
                                        ->where('question_id',$question->id)->first();
        
        $competency_id = \App\ExamQuestion::where('exam_id',$exam->id)->where('question_id',$question->id)->first()->basic_competency_id;

        return view('frontpage.exam.question-show', compact('exam','question','exam_response','number','competency_id'));
    }

    public function storeResponse(Request $request, Exam $exam, Question $question)
    {
        $user_id = Auth::id();

        $exam_result = ExamResult::where('user_id',$user_id)->where('exam_id',$exam->id)->first();

        if($question->question_type_id == 1)
        {
            $is_answer = AnswerChoice::find($request->answer_choice_id)->is_answer;

            $status = $is_answer ? 1 : 0;
            $score = $is_answer ? 1 : 0;

            $data = $request->only('exam_id','question_id','basic_competency_id','answer_choice_id') + ['user_id' => $user_id, 'status' => $status, 'score' => $score];
        }
        else if($question->question_type_id == 2)
        {
            $data = $request->only('exam_id','question_id','basic_competency_id','answer') + ['user_id' => $user_id];
        }

        $exam_result->examResponses()->updateOrCreate(
            [
                'user_id' => $user_id,
                'exam_id' => $exam->id,
                'question_id' => $question->id
            ], 
            $data
        );

        return $this->showNext($exam, $question);
    }

}
