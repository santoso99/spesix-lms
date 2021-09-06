<?php

namespace App\Http\Controllers\Task;

use App\TaskSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentTaskSubmissionController extends Controller
{
    public function index()
    {
        $submissions = TaskSubmission::with('user')->whereUserId(Auth::id())->get();

        return view('student.task-submission.index', compact('submissions'));
    }
}
