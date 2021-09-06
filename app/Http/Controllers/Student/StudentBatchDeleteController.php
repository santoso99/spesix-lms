<?php

namespace App\Http\Controllers\Student;

use App\Member as StudentMember;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\HandleImageTrait;

class StudentBatchDeleteController extends Controller
{
    use HandleImageTrait;

    public function __invoke(Request $request)
    {
        $student_ids = $request->student_id;

        if($student_ids == null){
            return back();
        }

        $users = User::whereIn('member_id',$student_ids)->select('avatar')->get();
        foreach($users as $user)
        {
            $this->deleteImage(public_path('storage/'.$user->avatar));
        }

        User::whereIn('member_id', $student_ids)->delete();
        StudentMember::whereIn('id', $student_ids)->delete();

        Cache::forget('students');

        return back()->with('status', __('messages.student_data_deleted'));
    }
}
