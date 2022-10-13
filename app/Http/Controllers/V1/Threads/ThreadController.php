<?php

namespace App\Http\Controllers\V1\Threads;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Message\SearchMessageRequest;
use App\Http\Requests\Thread\StoreThreadRequest;
use App\Http\Resources\ThreadResource;
use App\Models\Message;
use App\Models\Thread;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ThreadController extends BaseController
{
    /**
     * Create a thread in storage and returns it.
     */
    public function create(StoreThreadRequest $request): JsonResponse
    {
        $thread = Thread::create($request->validated());

        $responseData = [];
        $responseData['thread'] = new ThreadResource($thread);

        return $this->sendResponse($responseData, 201);
    }

    /**
     * Returns thread messages by thread id
     */
    public function getMessages(Thread $thread): JsonResponse
    {
        $messages = Message::where('thread_id', '=', $thread->id)->orderBy('created_at', 'desc')->get();

        if (count($messages) == 0) {
            $responseData = [];
            $responseData['message'] = 'Thread have not messages';

            return $this->sendResponseError($responseData);
        }

        $responseData = [];
        $responseData['messages'] = $messages;

        return $this->sendResponse($responseData);
    }

    /**
     * Returns all Messages that a given User has sent, that match a provided search term
     */
    public function searchUserThreadMessages(SearchMessageRequest $request, Thread $thread): JsonResponse
    {
        $userId = Auth::user()->id;
        $messages = Message::getMesthresagesByUserIdAndThreadIdAndSearchTerm($userId, $thread->id, $request->search_term);

        if (count($messages) == 0) {
            $responseData = [];
            $responseData['message'] = 'Messages not found';

            return $this->sendResponseError($responseData);
        }

        $responseData = [];
        $responseData['messages'] = $messages;

        return $this->sendResponse($responseData);
    }
}
