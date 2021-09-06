<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LearningPhaseFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'learning_topic_id' => $this->getTopicIdRule(),
        ];
    }

    private function getTopicIdRule()
    {
        $topic_id_rules = ($this->method() == 'PATCH') ? 'nullable' : 'required';

        return $topic_id_rules;
    }

}
