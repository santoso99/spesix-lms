<?php

namespace App\Http\Controllers\Student;

use App\User;
use App\Member;
use App\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentPromotionController extends Controller
{
    public function index()
    {
        $grades = Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get();
        $students = Member::whereNotNull('grade')->select('id','identity_number','name','grade')->get();

        return view('admin.student.promotion', compact('grades','students'));
    }

    public function promote(Request $request)
    {
        try {
            $current_grade_id = $request->grade_from;
            $new_grade_id = $request->grade_to;

            User::where('grade_id',$current_grade_id)->update(['grade_id' => $new_grade_id]);

            $current_grade_name = Grade::where('id',$current_grade_id)->pluck('name')[0];
            $new_grade_name = Grade::where('id',$new_grade_id)->pluck('name')[0];

            Member::where('grade',$current_grade_name)->update(['grade' => $new_grade_name]);

            return response()->json(array('success' => true));
        }
        catch(ModelNotFounException $e){
            return response()->json(array('error' => true));
        }
    }

    public function setGrade(Request $request)
    {
        $new_grade_id = $request->grade_id;
        $student_ids = $request->student_id;

        User::whereIn('member_id',$student_ids)->update(['grade_id' => $new_grade_id]);

        $new_grade_name = Grade::where('id',$new_grade_id)->pluck('name')[0];
        Member::whereIn('id',$student_ids)->update(['grade' => $new_grade_name]);

        return redirect('admin/students/promotion')->with('set-grade-status', __('messages.student_class_success_changed'));
    }
}
