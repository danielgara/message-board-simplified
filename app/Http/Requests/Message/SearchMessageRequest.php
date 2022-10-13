<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;

class SearchMessageRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search_term' => ['required', 'max:255'],
        ];
    }
}
