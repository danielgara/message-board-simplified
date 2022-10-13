<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;

class StoreMessageRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'body' => ['required', 'max:255'],
        ];
    }
}
