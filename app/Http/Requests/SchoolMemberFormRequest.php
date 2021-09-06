<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchoolMemberFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identity_number' => 'required|string',
            'name' => 'required|string|max:191',
            'pob' => 'required|string',
            'grade_id'=> 'nullable|exists:grades,id'
        ];
    }
}
