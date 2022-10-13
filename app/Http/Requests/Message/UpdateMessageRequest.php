<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;

class UpdateMessageRequest extends ApiFormRequest
{
    public function authorize()
    {
        $this->route("message"); //
        return true;
    }

    public function rules()
    {
        $messageId = $this->route()->parameter('messageId');
        $this->merge(['message_id' => $messageId]); //add message_id to the current request

        return [
            'body' => ['required', 'max:255'],
            'message_id' => ['required', 'exists:messages,id'],
        ];
    }
}
