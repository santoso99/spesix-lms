<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LearningTopicFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'school_year' => 'required|string|max:191',
            'semester' => 'required',
            'grade_level' => ['required',Rule::in([7,8,9])],
            'grade_id' => 'required',
            'rpp_file' => 'nullable|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd,png,jpg,jpeg,webp,xls,xlsx,zip,rar|max:10000',
            'competency_id' => 'required',
        ];
    }
}
