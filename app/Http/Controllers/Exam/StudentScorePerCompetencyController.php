<?php

namespace App\Http\Controllers\Exam;

use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentScorePerCompetencyController extends Controller
{
    public function __invoke(Request $request)
    {
        // Request contain exam_result_id
        if($request->ajax())
        {
            try {
                
                $exam_result = ExamResult::findOrFail($request->exam_result_id);
                $exam_question = \App\ExamQuestion::where('exam_id',$exam_result->exam_id)->get();
                $exam_responses = $exam_result->examResponses();

                $competency_ids = $exam_responses->distinct()->pluck('basic_competency_id')->toArray();
                $competencies = \App\BasicCompetency::whereIn('id',$competency_ids)->get();

                $competency_score_summary = [];
                
                foreach($competencies as $competency)
                {
                    $responses_competency = $exam_responses->where('basic_competency_id',$competency->id)->get();

                    $total_question = $exam_question->where('basic_competency_id',$competency->id)->count();
                    $correct_answer = $responses_competency->where('status',1)->count();
                    $score = $responses_competency->sum('score');

                    array_push($competency_score_summary, ['competency' => $competency->competency,'total_question' => $total_question, 'correct_answer' => $correct_answer, 'score' => $score]);
                }

                $other_responses_competency = $exam_result->examResponses()->whereNull('basic_competency_id')->get();

                if(count($other_responses_competency)>0)
                {
                    $total_question = $exam_question->whereNull('basic_competency_id')->count();
                    $correct_answer = $other_responses_competency->where('status',1)->count();
                    $score = $other_responses_competency->sum('score');

                    array_push($competency_score_summary, ['competency' => __('label.the_other'),'total_question' => $total_question, 'correct_answer' => $correct_answer, 'score' => $score]);
                }

                $view = view('admin.exam-result.competency-score-summary',compact('exam_result','competency_score_summary'))->render();

                return response()->json(['succes' => true, 'content' => $view]);

            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
