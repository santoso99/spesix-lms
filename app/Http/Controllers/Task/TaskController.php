<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\LearningTopic;
use App\Task;
use App\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\TaskFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Traits\HandleTaskInputTrait;

class TaskController extends Controller
{
    use HandleTaskInputTrait;

    public function index()
    {
        $role = Auth::user()->roles[0]->name;

        if($role == "Pengajar")
        {
            $user_id = Auth::id();
            $tasks = Task::with('learningTopic','user','subject')
                        ->where('user_id', $user_id)
                        ->select('id','name','deadline','status','learning_topic_id','user_id','subject_id')
                        ->get();
        }
        else
        {
            $tasks = Task::with('learningTopic','user','subject')
                        ->select('id','name','deadline','status','learning_topic_id','user_id','subject_id')
                        ->get();
        }

        return view('admin.task.index', compact('tasks'));
    }

    public function create(LearningTopic $topic = null)
    {
        $subjects = Subject::select('id','name')->get();

        return view('admin.task.create',compact('topic','subjects'));
    }

    public function store(TaskFormRequest $request)
    {
        if(isset($request->validated()['attachment_file'])){
            $this->addFileRequestData($request);
        }

        $request->request->add([
            'status' => 1,
            'user_id' => Auth::id(),
        ]);

        Task::create($request->all());

        return redirect('admin/tasks')->with('status',__('messages.assignment_published'));
    }

    public function edit(Task $task)
    {
        $subjects = Subject::select('id','name')->get();

        return view('admin.task.edit', compact('task','subjects'));
    }

    public function update(TaskFormRequest $request, Task $task)
    {
        if($request->attachment_file != null)
        {
            Storage::delete($task->attachment_path);
            $this->addFileRequestData($request);
        }

        $task->update($request->all());

        return redirect('admin/tasks')->with('status',__('messages.assignment_updated'));
    }

    public function destroy(Request $request)
    {
        $task_ids = $request->task_id;

        if($task_ids == null){
            return back();
        }

        $attachment_paths = Task::whereIn('id', $task_ids)->pluck('attachment_path')->toArray();

        Storage::delete(array_filter($attachment_paths));

        Task::whereIn('id', $task_ids)->delete();

        return redirect('admin/tasks')->with('status', __('messages.assignment_deleted'));
    }

}
