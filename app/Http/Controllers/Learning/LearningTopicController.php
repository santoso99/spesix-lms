<?php

namespace App\Http\Controllers\Learning;

use App\Grade;
use App\Subject;
use App\LearningTopic;
use App\LearningPhase;
use App\LearningMaterial;
use App\BasicCompetency;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\LearningTopicFormRequest;

class LearningTopicController extends Controller
{

    public function index()
    {
        $role = Auth::user()->roles[0]->name;

        if($role == "Pengajar")
        {
            $topics = LearningTopic::with(['subject','user','grades'])->where('user_id',Auth::id())->get();
        }
        else {
            $topics = LearningTopic::with(['subject','user','grades'])->get();
        }
        return view('admin.learning-topic.index', compact('topics'));
    }

    public function create()
    {
        $subjects = Subject::select('id', 'name')->get();
        $grades = Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get();

        return view('admin.learning-topic.create', compact('subjects','grades'));
    }

    public function store(LearningTopicFormRequest $request)
    {
        $data = $request->validated();
        $data['rpp_file'] = $this->getUploadedPath($request);
        $data['user_id'] = Auth::id();
        $data['enroll_code'] = uniqid();

        $topic = LearningTopic::create($data);

        $topic->grades()->attach(array_unique($request->grade_id));
        $topic->basicCompetencies()->attach(array_unique($request->competency_id));

        return redirect()->route('topics.materials', $topic->id)->with('status', __('messages.topic_data_created'));
    }

    public function show(LearningTopic $topic)
    {
        $materials = $topic->learningMaterials;
        
        return view('admin.learning-topic.show', compact('topic','materials'));
    }

    public function edit(LearningTopic $topic)
    {
        $subjects = Subject::select('id', 'name')->get();
        $grades = Grade::select('id','name')->orderBy('grade_level')->orderBy('name')->get();
        
        $topic_grades = [];
        
        foreach($topic->grades as $grade)
        {
            array_push($topic_grades, $grade->id);
        }

        return view('admin.learning-topic.edit', compact('subjects','grades','topic','topic_grades'));
    }

    public function update(LearningTopicFormRequest $request, LearningTopic $topic)
    {
        $data = $request->validated();

        if($request->rpp_file != null)
        {
            Storage::delete($topic->rpp_file);
            $data['rpp_file'] = $this->getUploadedPath($request);
        }

        $topic->update($data);

        $topic->grades()->sync(array_unique($request->grade_id));
        $topic->basicCompetencies()->sync(array_unique($request->competency_id));

        return redirect('admin/topics/'.$topic->id.'/edit')->with('status', __('messages.topic_data_updated'));
    }

    public function getTopicBySubject($subject)
    {
        $topics = LearningTopic::whereSubjectId($subject)->select('id','name')->get();

        return view('admin.partials.topic-select-item', compact('topics'))->render();
        // $topics_json = json_encode($topics);

        // return $topics_json;
    }

    private function getUploadedPath(LearningTopicFormRequest $request)
    {
        if(isset($request->validated()['rpp_file'])){
            $rpp_file = $request->validated()['rpp_file'];
            $ext = $rpp_file->extension();
            $name = pathinfo($rpp_file->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$ext;
            $rpp_file_path = $rpp_file->storeAs('uploads/rpp-files', $name);
        }
        
        return $rpp_file_path ?? null;
    }
}
