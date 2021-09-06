<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionFormRequest extends FormRequest
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
            'subject_id' => 'required|numeric',
            'title' => 'required|string',
            'question' => 'required|string',
            'question_type_id' => 'required|numeric',
            'is_answer' => 'nullable|numeric'
        ];
    }
}
