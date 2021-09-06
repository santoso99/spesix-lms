<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SOPFormRequest extends FormRequest
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
            'file' => $this->getIDRule(),
            'filename' => 'required|max:191|string'
        ];
    }

    private function getIDRule()
    {
        $id_rules = ($this->method() == 'PATCH') ? 'nullable|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd|max:5000' : 'required|file|mimes:doc,docx,odp,ods,odt,pdf,ppt,pptx,swf,vsd|max:5000';
        
        return $id_rules;
    }
}
