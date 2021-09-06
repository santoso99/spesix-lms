<?php

namespace App\Http\Controllers;

use App\BasicCompetency;
use Illuminate\Http\Request;

class BasicCompetencyController extends Controller
{
    public function filterBySubjectGrade(Request $request)
    {
        if($request->ajax())
        {
            try {
                $competencies = BasicCompetency::select('id','competency')->where('subject_id',$request->subject_id)->where('grade_level',$request->grade_level)->paginate(20);

                if(sizeof($competencies) == 0)
                {
                    return "<p class='text-center'>".__('label.no_data')."</p>";
                }
                else {
                    return view('admin.partials.competency-data', compact('competencies'))->render();
                }
            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }

    public function store(Request $request)
    {
        if($request->ajax())
        {
            try {
                $competency = BasicCompetency::create([
                    'subject_id' => $request->subject_id,
                    'grade_level' => $request->grade_level,
                    'competency' => $request->competency,
                ]);

                $competency_id = $competency->id;
                $competency_text = $request->competency;

                $views = view('admin.learning-topic.components.basic-competency-item-form', compact('competency_id','competency_text'))->render();
        
                return response()->json(['success' => true, 'kd_item' => $views]);
            } catch (\Throwable $th) {
                return response()->json(['error' => $th]);
            }
        }
    }
}
