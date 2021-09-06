<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\ExamResult;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamTogglePublishStatusController extends Controller
{
    public function __invoke(Request $request, Exam $exam)
    {
        try {
            $publish_status = !filter_var($request->publish_status, FILTER_VALIDATE_BOOLEAN);
            
            if($publish_status)
            {
                ExamResult::where('exam_id',$exam->id)->update(['correction_status' => 1]);
            }

            $exam->update(['publish_status' => $publish_status]);

            $publish_status = ($publish_status == 1) ? "publish" : "pending";
        } catch (\Throwable $e) {

            return response()->json(["error" => true, "e" => $e]);

        }

        return response()->json(['success' => true, 'message' => __('messages.exam_result_publish', ['status' => $publish_status])]);
    }
}
