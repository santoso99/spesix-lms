<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'subject_id' => 'required|numeric',
            'learning_topic_id' => 'required|numeric',
            'deadline' => 'required',
            'instruction' => 'required|string',
            'attachment_file' => 'nullable|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd,png,jpg,jpeg,webp,xls,xlsx,zip,rar,gzip|max:10000',
        ];
    }
}
