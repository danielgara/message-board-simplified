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
        $threadId = $this->route()->parameter('threadId');
        $this->merge(['thread_id' => $threadId]); //add thread_id to the current request

        return [
            'search_term' => ['required', 'max:255'],
            'thread_id' => ['required', 'exists:threads,id'],
        ];
    }
}
