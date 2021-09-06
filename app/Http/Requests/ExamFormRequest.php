<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamFormRequest extends FormRequest
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
            'title' => 'required|string|max:191',
            'subject_id' => 'required|numeric',
            'grade_id' => 'required',
            'kkm_score' => 'required|lt:max_score',
            'date' => 'required|date',
            'time_start' => 'required',
            'time_end' => 'required',
            'max_score' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'kkm_score.lt' => 'Nilai KKM harus lebih kecil dari Nilai Maksimal',
        ];
    }

    public function attributes()
        {
            return [
                'kkm_score' => 'Nilai KKM',
            ];
        }
}
