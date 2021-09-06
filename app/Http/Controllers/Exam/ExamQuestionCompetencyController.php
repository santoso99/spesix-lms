<?php

namespace App\Http\Controllers\Exam;

use App\ExamQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamQuestionCompetencyController extends Controller
{
    public function update(Request $request, ExamQuestion $exam_question)
    {
        if($request->ajax())
        {
            try{
                $exam_question->update(['basic_competency_id' => $request->competency_id]);

                return response()->json(['success' => true, 'message' => __('messages.competency_added_to_question')]);
            }
            catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
