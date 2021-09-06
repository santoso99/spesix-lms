<?php

namespace App\Http\Controllers\Frontpage;

use App\Task;
use App\TaskSubmission;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskSubmissionFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskSubmissionController extends Controller
{
    public function store(TaskSubmissionFormRequest $request)
    {
        $this->completeRequestData($request);

        TaskSubmission::create($request->all());

        return redirect('tasks/'.$request->task_id)->with('status',__('messages.assignment_submitted'));
    }

    public function update(TaskSubmissionFormRequest $request, TaskSubmission $submission)
    {
        if($submission->submission_path != null){
            Storage::delete($submission->submission_path);
        }

        $this->completeRequestData($request);

        $submission->update($request->all());
        return redirect('tasks/'.$request->task_id)->with('status',__('messages.assignment_submit_updated'));
    }

    private function completeRequestData(TaskSubmissionFormRequest $request)
    {
        $submission_path = $this->getUploadedPath($request);

        if(isset($request->validated()['task_file'])){
            $submissions = $request->validated()['task_file'];
            $submissions_filename = $submissions->getClientOriginalName();
        }

        $submission_date = date('Y-m-d H:i:s');
        $deadline = date('Y-m-d H:i:s', strtotime(Task::findOrFail($request->task_id)->deadline));

        $status = ($submission_date < $deadline) ? 1 : 2;
        
        $request->request->add([
            'submission_path' => $submission_path ?? null,
            'submission_filename' => $submissions_filename,
            'status' => $status,
            'user_id' => Auth::id(),
        ]);
    }

    private function getUploadedPath(TaskSubmissionFormRequest $request)
    {
        if(isset($request->validated()['task_file'])){
            $submissions = $request->validated()['task_file'];
            $ext = $submissions->extension();
            $name = pathinfo($submissions->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$ext;
            $submission_path = $submissions->storeAs('uploads/task-submissionss', $name);
        }

        return $submission_path;
    }

}
