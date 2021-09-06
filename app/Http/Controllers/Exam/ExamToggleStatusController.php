<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExamToggleStatusController extends Controller
{

    public function __invoke(Request $request, Exam $exam)
    {
        try {
            $status = !filter_var($request->status, FILTER_VALIDATE_BOOLEAN);
            $exam->update(['status' => $status]);

            $status = ($status == 1) ? __('label.open') : __('label.closed');
        } catch (\Throwable $e) {

            return response()->json(["error" => true, "e" => $e]);

        }

        return response()->json(['success' => true, 'message' => __('messages.exam_status', ['status' => $status])]);
    }
}
