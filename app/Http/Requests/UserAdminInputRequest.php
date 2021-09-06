<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserAdminInputRequest extends FormRequest
{
  
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'identity_number' => $this->getIDRule(),
            'name' => 'required|string|max:191',
            'role' => 'required|string',
            'email' => $this->getEmailRule(),
            'password' => $this->getPasswordRule(),
        ];
    }

    private function getIDRule()
    {
        $id_rules = ($this->method() == 'PATCH') ? 'required|string' : 'required|string|unique:members,identity_number';
        
        return $id_rules;
    }

    private function getEmailRule()
    {
        $email_rules = ($this->method() == 'PATCH') ? 'required|string|email|max:255' : 'required|string|email|max:255|unique:users';
        
        return $email_rules;
    }

    private function getPasswordRule()
    {
        $pass_rules = ($this->method() == 'PATCH') ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed';
        
        return $pass_rules;
    }
}
