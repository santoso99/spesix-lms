<?php

namespace App\Http\Controllers\Exam;

use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RemedialScoreController extends Controller
{
    public function input(Request $request, ExamResult $exam_result)
    {
        $final_score = ($exam_result->score + $request->remedial_score) / 2;
        $exam_status = ($request->is_remedial == 0) ? "<span class='text-success'>".__('label.pass_with_remedial')."</span>" : "<span class='text-danger'>".__('label.failed')."</span>";

        $exam_result->update(['is_remedial' => $request->is_remedial, 'remedial_score' => $request->remedial_score, 'final_score' => $final_score]);

        return response()->json(['success' => true, 'message' => __('messages.remed_score_added'), 'exam_status' => $exam_status, 'final_score' => $final_score]);
    }

    public function get(ExamResult $exam_result)
    {
        return response()->json(['success' => true, 'remedial_score' => $exam_result->remedial_score, 'is_remedial' => $exam_result->is_remedial]);
    }
}
