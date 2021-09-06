<?php

namespace App\Http\Controllers\Parent;

use App\Member;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Http\Requests\ParentFormRequest;

class ParentController extends Controller
{
    public function index()
    {
        $parents = User::role('Wali Siswa')->get();
        
        return view('admin.parent.index', compact('parents'));
    }

    public function create(User $student)
    {
        if($student->member->is_account_created == 0)
        {
            return redirect()->route('parents.index')->with('status', __('messages.create_student_account_first'));
        }

        return view('admin.parent.create', compact('student'));
    }

    public function store(User $student, ParentFormRequest $request)
    {
        if($student->member->is_account_created == 0)
        {
            return redirect()->route('parents.index')->with('status', __('messages.create_student_account_first'));
        }
        
        $parent = $student->parent()->create($request->only(['name','email','password']));
        $parent->assignRole('Wali Siswa');

        return redirect()->route('parents.index')->with('status', __('messages.parent_account_created'));
    }

    public function edit(User $parent)
    {
        return view('admin.parent.edit', compact('parent'));
    }

    public function update(User $parent, ParentFormRequest $request)
    {
        $parent->update($request->only(['name', 'email']));

        return redirect()->route('parents.index')->with('status', __('messages.parent_account_updated'));
    }

    public function batchDelete(Request $request)
    {
        $parent_ids = $request->parent_id;

        for($i=0;$i<count($parent_ids);$i++)
        {
            $user = User::findOrFail($parent_ids[$i]);

            $user->roles()->detach();
            $user->forgetCachedPermissions();
        }

        User::whereIn('id', $parent_ids)->delete();

        return redirect()->route('parents.index')->with('status', __('messages.parent_account_deleted'));
    }
    
}
