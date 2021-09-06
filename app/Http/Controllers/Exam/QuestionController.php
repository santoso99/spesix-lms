<?php

namespace App\Http\Controllers\Exam;

use App\Subject;
use App\QuestionType;
use App\Question;
use App\AnswerChoice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\QuestionFormRequest;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    public function index()
    {
        $subjects = Subject::select('id','name')->get();
        $role = Auth::user()->roles[0]->name;

        if(($role == "Admin") || ($role == "Supervisor"))
        {
            $questions = Question::with('questionType')->select('id','question_type_id','title','excerpt')->get();
        }
        else if($role == "Pengajar") {
            $questions = Question::with('questionType')->select('id','question_type_id','title','excerpt')->where('user_id', Auth::id())->get();
        }

        return view('admin.question.index', compact('questions','subjects'));
    }

    public function indexBySubject(Subject $subject)
    {
        $subjects = Subject::select('id','name')->get();
        $role = Auth::user()->roles[0]->name;

        if(($role == "Admin") || ($role == "Supervisor"))
        {
            $questions = Question::with('questionType')->select('id','question_type_id','title','excerpt')->where('subject_id',$subject->id)->get();
        }
        else if($role == "Pengajar"){
            $questions = Question::with('questionType')->select('id','question_type_id','title','excerpt')->where('user_id', Auth::id())->where('subject_id',$subject->id)->get();
        }

        return view('admin.question.index', compact('questions','subjects','subject'));
    }

    public function create()
    {
        $subjects = Subject::select('id','name')->get();
        $question_types = QuestionType::select('id','name')->get();

        return view('admin.question.create', compact('question_types','subjects'));
    }

    public function store(QuestionFormRequest $request)
    {
        $user_id = Auth::id();

        $question = Question::create($request->only('question_type_id','subject_id','title','question') + ['user_id' => $user_id, 'excerpt' => $request->question]);

        if($request->question_type_id == 1)
        {
            $answer_choices = $this->getAnswerChoiceData($question->id,$request->answers, $request->is_answer);
            
            foreach($answer_choices as $answer_choice)
            {
                AnswerChoice::create($answer_choice);
            }

        }

        return redirect('admin/questions/subjects/'.$request->subject_id)->with('status',__('messages.question_data_created'));
    }

    public function getAnswerChoiceData($question_id, $answers, $is_answer)
    {
        $labels = ["A","B","C","D","E"];
        $answer_choices = [];

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

    public function show(Question $question)
    {
        return view('admin.question.show', compact('question'));
    }

    public function edit(Question $question)
    {
        $answer_choices = null;
        if($question->question_type_id == 1)
        {
            $answer_choices = $question->answerChoices;
        }
        
        return view('admin.question.edit', compact('question','answer_choices'));
    }

    public function update(Request $request, Question $question)
    {
        $user_id = Auth::id();

        $question->update($request->only('title','question') + ['user_id' => $user_id,'excerpt' => $request->question]);

        if($request->has('answers'))
        {
            $labels = ["A","B","C","D","E"];
            $question_id = $question->id;
            $answer_choices = $question->answerChoices;
            $answers = $request->answers;
            $is_answer_id = $request->is_answer;
            $i = 0;

            foreach($answer_choices as $answer_choice)
            {
                $answer_choice->update([
                    'question_id' => $question_id, 
                    'label' => $labels[$i],
                    'text' => $answers[$i], 
                    'is_answer' => ($answer_choice->id == $is_answer_id) ? 1 : 0,
                ]);

                $i++;
            }
        }

        return redirect('admin/questions/subjects/'.$question->subject_id)->with('status',__('messages.question_data_updated'));
    }

    public function destroy(Request $request)
    {
        $question_ids = $request->question_id;

        if($question_ids == null){
            return back();
        }

        AnswerChoice::whereIn('question_id',$question_ids)->delete();
        Question::whereIn('id', $question_ids)->delete();

        return redirect('admin/questions')->with('status', __('messages.question_data_deleted'));
    }
}
