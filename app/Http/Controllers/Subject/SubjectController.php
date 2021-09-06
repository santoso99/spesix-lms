<?php

namespace App\Http\Controllers\Subject;

use App\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Cache::remember('subjects', config('cache.duration.long'), function(){
            return Subject::select('id', 'name')->get();
        });
        return view('admin.subject.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        Subject::create(['name' => $request->name]);
        
        return back()->with('status', __('messages.subject_data_created'));
    }

    public function edit(Subject $subject)
    {
        return view('admin.subject.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $subject->update($request->only('name'));

        return redirect('admin/subjects')->with('status', __('messages.subject_data_updated'));
    }
}
