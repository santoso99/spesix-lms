<?php

namespace App\Http\Controllers\Exam;

use App\Subject;
use App\QuestionType;
use App\Question;
use App\Exam;
use App\AnswerChoice;
use App\BasicCompetency;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionFormRequest;
use Illuminate\Support\Facades\Auth;

class ExamQuestionController extends Controller
{
    public function create(Exam $exam)
    {
        $subjects = Subject::select('id','name')->get();
        $question_types = QuestionType::select('id','name')->get();

        return view('admin.exam.create-question', compact('question_types','subjects','exam'));
    }

    public function store(QuestionFormRequest $request, Exam $exam)
    {
        $user_id = Auth::id();

        $question = Question::create(
                    $request->only('question_type_id','title','subject_id','question') + 
                    [
                        'user_id' => $user_id, 
                        'excerpt' => $request->question
                    ]
                );

        $highest_question_number = $exam->questions()->max('number');
        $exam->questions()->attach(
                    $question->id, 
                    [
                        'number' => $highest_question_number+1
                    ]
                );

        $total_question = $exam->total_question+1;
        $exam->update(['total_question' => $total_question]);

        if($request->question_type_id == 1)
        {
            $answer_choices = $this->getAnswerChoiceData(
                                $question->id,
                                $request->answers, 
                                $request->is_answer
                            );
            
            foreach($answer_choices as $answer_choice)
            {
                AnswerChoice::create($answer_choice);
            }

        }

        $this->reorderQuestion($exam);

        return redirect('admin/exams/'.$exam->id.'/edit')->with('status',__('messages.question_data_created'));
    }

    public function getAnswerChoiceData($question_id, $answers, $is_answer)
    {
        $labels = ["A","B","C","D","E"];
        $answer_choices = [];
        $answers = array_filter($answers, function($value) { return !is_null($value) && $value !== '';});

        for($i=0;$i<count($answers);$i++)
        {
            $answer_choices[$i] = [
                'question_id' => $question_id, 
                'label' => $labels[$i],
                'text' => $answers[$i], 
                'is_answer' => ($is_answer-1 == $i) ? 1 : 0,
            ];
        }

        return $answer_choices;
    }

    public function destroy(Request $request, Exam $exam)
    {
        $question_ids = $request->question_id;

        if($question_ids == null){
            return back();
        }

        $exam->questions()->detach($question_ids);

        $old_total_question = $exam->total_question;
        $count_deleted_questions = count($question_ids);
        $new_total_question = $old_total_question - $count_deleted_questions;
        $exam->update(['total_question' => $new_total_question]);

        $this->reorderQuestion($exam);

        return redirect('admin/exams/'.$exam->id.'/edit')->with('status', __('messages.question_removed_from_evaluation'));
    }

    public function reorderQuestion(Exam $exam)
    {
        $exam_questions = $exam->questions;
        $no = 0;

        foreach ($exam_questions as $exam_question) {
            $exam_question->pivot->update(['number' => ++$no]);
        }
    }

    public function addToExam(Request $request, Exam $exam)
    {
        try {
            $highest_question_number = $exam->questions()->max('number');
            $question_ids = $request->question_ids;

            $pivotData = array_fill(0, count($question_ids),['number' => 0]);

            for($i=0;$i<count($question_ids);$i++)
            {
                $pivotData[$i]['number'] = ++$highest_question_number;
            }

            $attachData = array_combine($question_ids, $pivotData);
            $exam->questions()->attach($attachData);

            $old_total_question = $exam->total_question;
            $count_added_questions = count($question_ids);
            $new_total_question = $old_total_question + $count_added_questions;
            $exam->update(['total_question' => $new_total_question]);
            
            $exam_questions = $exam->questions;
            $competencies = BasicCompetency::where('subject_id',$exam->subject_id)->select('id','competency')->get();

            $view = view('admin.exam.new-added-exam-question', compact('exam_questions','competencies'))->render();

            return response()->json(['success' => true, 'message' => __('messages.question_added_to_evaluation'), 'content' => $view]);
        }
        catch (\Throwable $e) {
            return response()->json(['error' => true, 'message' => __('messages.question_failed_to_evaluation')]);
        }
    }
}
