<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Exam;

class StudentExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with('subject','user')->where('status',1)->get();

        return view('student.exam.index', compact('exams'));
    }
}
