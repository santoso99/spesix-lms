<?php

namespace App\Http\Controllers\Exam;

use App\Exam;
use App\Subject;
use App\Grade;
use App\QuestionType;
use App\BasicCompetency;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\ExamFormRequest;
use Illuminate\Support\Carbon;

class ExamController extends Controller
{

    public function index()
    {
        $role = Auth::user()->roles[0]->name;

        if($role == "Pengajar")
        {
            $exams = Exam::with('subject')->select('id','subject_id','enroll_code','title','date','time_start','time_end','status','publish_status','total_question')->where('user_id',Auth::id())->get();
        }
        elseif(($role == 'Admin') || ($role == 'Supervisor')) {
            $exams = Exam::with('subject')->select('id','subject_id','enroll_code','title','date','time_start','time_end','status','publish_status','total_question')->get();
        }

        return view('admin.exam.index', compact('exams'));
    }

    public function create()
    {
        $subjects = Subject::select('id','name')->get();
        $grades = Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get();

        return view('admin.exam.create', compact('subjects','grades'));
    }

    public function store(ExamFormRequest $request)
    {
        $user_id = Auth::id();
        $enroll_code = substr(uniqid(),0,6);
        $exam = Exam::create($request->only('subject_id','title','grade_level','date','time_start','time_end','kkm_score','max_score') + ['user_id' => $user_id,'enroll_code' => $enroll_code]);

        $exam->grades()->attach($request->grade_id);

        return $this->edit($exam, __('messages.evaluation_data_created', ['code'=> $enroll_code]));
    }

    public function edit(Exam $exam, $exam_status = null)
    {
        $subjects = Subject::select('id','name')->get();
        $grades = Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get();
        $question_types = QuestionType::select('id','name')->get();
        $competencies = BasicCompetency::where('subject_id',$exam->subject_id)->select('id','competency')->get();

        $exam_questions = $exam->questions;
        $exam_grades = [];
        
        foreach($exam->grades as $grade)
        {
            array_push($exam_grades, $grade->id);
        }

        return view('admin.exam.edit', compact('exam','subjects','grades','exam_grades','exam_questions','question_types','competencies', 'exam_status'));
    }

    public function update(ExamFormRequest $request, Exam $exam)
    {
        $user_id = Auth::id();
        $exam->update($request->only('subject_id','title','grade_level','date','time_start','time_end','kkm_score','max_score') + ['user_id' => $user_id]);
        
        $exam->grades()->sync($request->grade_id);

        return $this->edit($exam, __('messages.evaluation_data_updated'));
    }

    public function destroy(Request $request)
    {
        $exam_ids = $request->exam_id;

        if($exam_ids == null){
            return back();
        }

        DB::table('exam_grade')->whereIn('exam_id',$exam_ids)->delete();
        Exam::whereIn('id', $exam_ids)->delete();

        return redirect('admin/exams')->with('status', __('messages.evaluation_data_deleted'));
    }
}
