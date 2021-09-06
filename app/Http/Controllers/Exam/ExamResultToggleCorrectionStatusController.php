<?php

namespace App\Http\Controllers\Exam;

use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamResultToggleCorrectionStatusController extends Controller
{
    public function __invoke(Request $request, ExamResult $exam_result)
    {
        try {
            $status = !filter_var($request->status, FILTER_VALIDATE_BOOLEAN);

            if($status == false)
            {
                $exam_result->update(['correction_status' => $status]);
            }
            else {
                $score = $exam_result->examResponses->sum('score');
                $final_score = $score;
                $total_answered_question = $exam_result->examResponses->count();
                $total_correct_answer = $exam_result->examResponses->where('status',1)->count();
                $total_wrong_answer = $exam_result->examResponses->whereNotNull('answer_choice_id')->where('status',0)->count();

                if($exam_result->remedial_score > 0)
                {
                    $final_score = ($score + $exam_result->remedial_score)/2;
                }

                $is_remedial = ($final_score < $exam_result->exam->kkm_score) ? 1 : 0;

                $exam_result->update([
                    'score' => $score,
                    'is_remedial' => $is_remedial,
                    'final_score' => $final_score ?? $exam_result->final_score,
                    'correction_status' => $status,
                    'total_answered_question' => $total_answered_question,
                    'total_correct_answer' => $total_correct_answer,
                    'total_wrong_answer' => $total_wrong_answer
                ]);
            }
            
            return response()->json(['success' => true, 'message' => __('messages.correction_status_changed')]);

        } catch (\Throwable $e) {

            return response()->json(["error" => true, "e" => $e]);

        }

    }
}
