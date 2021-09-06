<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningMaterialFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'material' => 'nullable|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd,png,jpg,jpeg,webp,xls,xlsx,zip,rar,gzip,mp4,avi,flv,wmv,mov,3gp,mkv|max:10000',
            'content' => 'required|string',
            'learning_topic_id' => 'required|numeric',
        ];
    }
}
