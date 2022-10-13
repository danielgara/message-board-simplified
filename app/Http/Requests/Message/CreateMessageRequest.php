<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;

class CreateMessageRequest extends ApiFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route()->parameter('userId');
        $threadId = $this->route()->parameter('threadId');
        $this->merge(['user_id' => $userId]); //add user_id to the current request
        $this->merge(['thread_id' => $threadId]); //add thread_id to the current request

        return [
            'body' => ['required', 'max:255'],
            'user_id' => ['required', 'exists:users,id'],
            'thread_id' => ['required', 'exists:threads,id'],
        ];
    }
}
