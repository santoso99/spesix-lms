<?php

namespace App\Http\Controllers\Grade;

use App\Grade;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\GradeFormRequest;

class GradeController extends Controller
{
    public function index()
    {
        $grades = Cache::remember('grades', config('cache.duration.long'), function(){
            return Grade::select('id', 'name')->orderBy('grade_level')->orderBy('name')->get();
        });
        return view('admin.grade.index', compact('grades'));
    }

    public function store(GradeFormRequest $request)
    {
        Grade::create($request->only('name','grade_level'));
        return back()->with('status', __('messages.grade_data_created'));
    }

    public function edit(Grade $grade)
    {
        return view('admin.grade.edit', compact('grade'));
    }

    public function update(GradeFormRequest $request, Grade $grade)
    {
        $grade->update($request->only('name'));
        return redirect('admin/grades')->with('status', __('messages.grade_data_updated'));
    }
}
