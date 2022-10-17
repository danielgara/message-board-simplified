<?php

namespace App\Http\Requests\Message;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMessageRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * SH - I'm not sure where this pattern of authorization came from, maybe it's used somewhere but I'm not familiar
     * with it.  Laravel provides Gates and Policies for dealing with this--I believe those would be better to use
     * since they can be used independently of a request, and as our application grows there may be cases where
     * we want to check this logic in other contexts.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = Auth::user();
        $messageUserId = $this->route('message')->user_id;
        if (! $user->isCurrentUser($messageUserId)) {
            return false;
        }

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
            'body' => ['required', 'max:255'],
        ];
    }
}
