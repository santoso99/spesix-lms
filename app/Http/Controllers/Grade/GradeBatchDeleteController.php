<?php

namespace App\Http\Controllers\Grade;

use App\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class GradeBatchDeleteController extends Controller
{
    public function __invoke(Request $request)
    {
        $grade_ids = $request->grade_id;

        if($grade_ids == null){
            return back();
        }

        Grade::whereIn('id', $grade_ids)->delete();

        Cache::forget('grades');

        return back()->with('status', __('messages.grade_data_deleted'));
    }
}
