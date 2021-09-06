<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAvatarRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'avatar' => 'required|file|image|max:200|mimes:jpeg,bmp,jpg,png',
        ];
    }
}
