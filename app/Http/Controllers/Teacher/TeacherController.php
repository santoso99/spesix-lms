<?php

namespace App\Http\Controllers\Teacher;

use App\Member;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\SchoolMemberFormRequest;
use App\Traits\HandleImageTrait;

class TeacherController extends Controller
{

    use HandleImageTrait;

    public function index()
    {
        $teachers = Cache::remember('teachers', config('cache.duration.long'), function(){
            return Member::whereNull('grade')->select('id','identity_number','name','is_account_created')->get();
        });
        return view('admin.teacher.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teacher.create');
    }

    public function store(SchoolMemberFormRequest $request)
    {
        Member::create($request->all());
        return redirect('admin/teachers')->with('status', __('messages.teacher_data_created'));
    }

    public function edit(Member $teacher)
    {
        return view('admin.teacher.edit', compact('teacher'));
    }

    public function update(SchoolMemberFormRequest $request, Member $teacher)
    {
        $teacher->update($request->all());

        $user = $teacher->user;

        if($user)
        {
            $user->update([
                'name'=> $request->name,
            ]);
        }

        return redirect('admin/teachers')->with('status', __('messages.teacher_data_updated'));
    }
}
