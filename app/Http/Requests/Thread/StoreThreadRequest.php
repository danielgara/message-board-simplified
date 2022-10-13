<?php

namespace App\Http\Requests\Thread;

use App\Http\Requests\ApiFormRequest;

class StoreThreadRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
        ];
    }
}
