<?php

namespace App\Http\Controllers\Parent;

use App\TaskSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentTaskSubmissionController extends Controller
{
    public function index()
    {
        $submissions = TaskSubmission::with('user')->whereUserId(Auth::user()->student->id)->get();

        return view('student.task-submission.index', compact('submissions'));
    }
}
