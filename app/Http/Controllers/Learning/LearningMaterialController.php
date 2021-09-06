<?php

namespace App\Http\Controllers\Learning;

use App\LearningTopic;
use App\LearningPhase;
use App\LearningMaterial;
use App\Http\Controllers\Controller;
use App\Http\Requests\LearningMaterialFormRequest;
use Illuminate\Support\Facades\Storage;

class LearningMaterialController extends Controller
{

    public function index(LearningTopic $topic)
    {
        $materials = $topic->learningMaterials;

        return view('admin.learning-material.index', compact('topic','materials'));
    }

    public function store(LearningMaterialFormRequest $request)
    {
        $this->getUploadedPath($request);

        $topic_id = $request->validated()['learning_topic_id'];
        
        LearningMaterial::create($request->only('name','file_path','content','learning_topic_id'));

        return redirect()->route('topics.materials',$topic_id)->with('status', __('messages.learning_material_added'));
    }

    public function edit(LearningMaterial $material)
    {
        return view('admin.learning-material.edit', compact('material'));
    }

    public function update(LearningMaterialFormRequest $request, LearningMaterial $material)
    {
        if($material->file_path != null){
            Storage::delete($material->file_path);
        }

        $this->getUploadedPath($request);
        $material->update($request->only('name','file_path','content'));

        return redirect()->route('topics.materials', $material->learningTopic->id)->with('status', __('messages.learning_material_updated'));
    }

    public function destroy(learningMaterial $material)
    {
        Storage::delete($material->file_path);
        $material->delete();

        return redirect()->route('topics.materials', $material->learningTopic->id)->with('status', __('messages.learning_material_deleted'));
    }

    private function getUploadedPath(LearningMaterialFormRequest $request)
    {
        if(isset($request->validated()['material'])){
            $material = $request->validated()['material'];
            $ext = $material->extension();
            $name = pathinfo($material->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$ext;
            $file_path = $material->storeAs('uploads/materials', $name);
        }
        
        $request->request->add([
            'file_path' => $file_path ?? null,
        ]);
    }
}
