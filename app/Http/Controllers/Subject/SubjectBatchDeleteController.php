<?php

namespace App\Http\Controllers\Subject;

use App\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubjectBatchDeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $subject_ids = $request->subject_id;

        if($subject_ids == null){
            return back();
        }

        Subject::whereIn('id', $subject_ids)->delete();

        Cache::forget('subjects');

        return back()->with('status', __('messages.subject_data_deleted'));
    }
}
