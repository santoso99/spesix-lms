<?php

namespace App\Traits;

use App\Http\Requests\TaskFormRequest;
use Illuminate\Support\Facades\Auth;

trait HandleTaskInputTrait {

    public function addFileRequestData(TaskFormRequest $request)
    {
        $attachment_path = $this->getUploadedPath($request);

        $attachment = $request->validated()['attachment_file'];
        $attachment_filename = $attachment->getClientOriginalName();

        $request->request->add([
            'attachment_path' => $attachment_path,
            'attachment_filename' => $attachment_filename,
        ]);
    }

    public function getUploadedPath(TaskFormRequest $request)
    {
        $attachment = $request->validated()['attachment_file'];
        $ext = $attachment->extension();
        $name = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME).'-'.uniqid().'.'.$ext;
        $attachment_path = $attachment->storeAs('uploads/task-attachments', $name);

        return $attachment_path;
    }

}