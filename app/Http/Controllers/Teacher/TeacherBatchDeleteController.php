<?php

namespace App\Http\Controllers\Teacher;

use App\Member as TeacherMember;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Traits\HandleImageTrait;

class TeacherBatchDeleteController extends Controller
{

    use HandleImageTrait;

    public function __invoke(Request $request)
    {
        $teacher_ids = $request->teacher_id;

        if($teacher_ids == null){
            return back();
        }

        $users = User::whereIn('member_id',$teacher_ids)->select('avatar')->get();
        foreach($users as $user)
        {
            $this->deleteImage(public_path('storage/'.$user->avatar));
        }

        User::whereIn('member_id', $teacher_ids)->delete();
        TeacherMember::whereIn('id', $teacher_ids)->delete();

        Cache::forget('teachers');

        return back()->with('status', __('messages.teacher_data_deleted'));
    }
}
