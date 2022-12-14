<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;

class SearchMessageRequest extends ApiFormRequest
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
            'search_term' => ['required', 'max:255'],
        ];
    }
}
