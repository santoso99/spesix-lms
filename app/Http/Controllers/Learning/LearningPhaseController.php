<?php

namespace App\Http\Controllers\Learning;

use App\LearningTopic;
use App\LearningPhase;
use App\LearningMaterial;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LearningPhaseFormRequest;
use Illuminate\Http\Request;

class LearningPhaseController extends Controller
{

    public function index(LearningTopic $topic)
    {
        $steps = LearningPhase::whereLearningTopicId($topic->id)->get();

        return view('admin.learning-phase.index', compact('steps','topic'));
    }

    public function create(LearningTopic $topic)
    {
        $steps = LearningPhase::whereLearningTopicId($topic->id)->get();

        return view('admin.learning-phase.create', compact('steps','topic'));
    }

    public function store(LearningPhaseFormRequest $request)
    {
        $step = LearningPhase::create($request->validated());
        // $topic_id = $request->validated()['learning_topic_id'];

        return response()->json(array(
            "success" => true, 
            "message" => __('messages.learning_step_added'),
            "step_id" => $step->id
        ));
    }

    public function show(LearningPhase $step)
    {
        
    }

    public function edit(LearningPhase $step)
    {
        $topic = LearningTopic::whereId($step->learning_topic_id)->select('id','name')->first();
        $materials = LearningMaterial::whereLearningPhaseId($step->id)->get();

        return view('admin.learning-phase.edit', compact('topic','step','materials'));
    }

    public function update(LearningPhaseFormRequest $request, LearningPhase $step)
    {
        $step->update($request->validated());

        return response()->json(array("success" => true, "message" => __('messages.learning_step_updated')));
    }

    public function destroy(Request $request)
    {
        $step_ids = $request->step_id;

        if($step_ids == null){
            return back();
        }

        $material_files = LearningMaterial::whereIn('learning_phase_id', $step_ids)->pluck('file_path')->toArray();

        Storage::delete(array_filter($material_files));

        LearningPhase::whereIn('id', $step_ids)->delete();

        return back()->with('status', __('messages.learning_step_deleted'));
    }
}
