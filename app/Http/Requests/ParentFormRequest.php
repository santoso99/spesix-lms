<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentFormRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'unique:users,email,'.$this->parent->id, 'max:191'],
            'password' => $this->getPasswordRule(),
        ];
    }

    private function getPasswordRule()
    {
        $pass_rules = ($this->method() == 'PATCH') ? 'nullable|string|min:8|confirmed|max:191' : 'required|string|min:8|confirmed|max:191';
        
        return $pass_rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi',
            'name.max' => 'Panjang nama maksimal :max karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email salah',
            'email.max' => 'Panjang email maksimal :max karakter',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal :min karakter',
            'password.max' => 'Password maksimal :max karakter',
        ];
    }
}
