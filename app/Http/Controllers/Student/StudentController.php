<?php

namespace App\Http\Controllers\Student;

use App\Member;
use App\Grade;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolMemberFormRequest;
use Illuminate\Support\Facades\Cache;
use App\Traits\HandleImageTrait;

class StudentController extends Controller
{
    use HandleImageTrait;

    public function index()
    {
        $students = Cache::remember('students', config('cache.duration.long'), function(){
            return Member::whereNotNull('grade')->select('id','identity_number','name','grade','is_account_created')->get();
        });

        return view('admin.student.index', compact('students'));
    }

    public function create()
    {
        return view('admin.student.create');
    }

    public function store(SchoolMemberFormRequest $request)
    {
        Member::create($request->all());
        
        return redirect('admin/students')->with('status', __('messages.student_data_created'));
    }

    public function edit(Member $student)
    {
        return view('admin.student.edit', compact('student'));
    }

    public function update(SchoolMemberFormRequest $request, Member $student)
    {
        $student->update($request->all());

        $user = $student->user;

        if($user)
        {
            $grade_id = Grade::where('name',$request->grade)->first()->id;

            $user->update([
                'grade_id' => $grade_id,
                'name'=> $request->name,
            ]);
        }

        return redirect('admin/students')->with('status', __('messages.student_data_updated'));
    }
}