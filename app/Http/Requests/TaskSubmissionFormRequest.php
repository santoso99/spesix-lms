<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskSubmissionFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'task_id' => 'required|numeric',
            'task_file' => 'required|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd,png,jpg,jpeg,webp,xls,xlsx,zip,rar,gzip|max:15000',
        ];
    }
}
