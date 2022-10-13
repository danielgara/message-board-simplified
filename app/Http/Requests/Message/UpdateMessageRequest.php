<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMessageRequest extends ApiFormRequest
{
    public function authorize()
    {
        $user = Auth::user();
        $messageUserId = $this->route('message')->user_id;
        if (! $user->isCurrentUser($messageUserId)) {
            return false;
        }

        return true;
    }

    public function rules()
    {
        return [
            'body' => ['required', 'max:255'],
        ];
    }
}
