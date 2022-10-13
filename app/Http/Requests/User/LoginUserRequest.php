<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;

class LoginUserRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'max:255'],
        ];
    }
}
