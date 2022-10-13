<?php

namespace App\Http\Controllers\V1\Threads;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Message\StoreMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Thread;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserThreadMessageController extends BaseController
{
    /**
     * Create a message in storage and returns it.
     */
    public function createMessage(StoreMessageRequest $request, User $user, Thread $thread): JsonResponse
    {
        $message = Message::create(array_merge(
            $request->validated(),
            [
                'user_id' => $user->id,
                'thread_id' => $thread->id,
            ],
        ));

        $responseData = [];
        $responseData['message'] = new MessageResource($message);

        return $this->sendResponse($responseData, 201);
    }

    /**
     * Get threads in which user has parcipated.
     */
    public function getUserThreads(User $user): JsonResponse
    {
        $threads = Thread::getThreadsByUserId($user->id);

        if (count($threads) == 0) {
            $responseData = [];
            $responseData['message'] = 'Threads not found';

            return $this->sendResponseError($responseData);
        }

        $responseData = [];
        $responseData['threads'] = $threads;

        return $this->sendResponse($responseData);
    }

    /**
     * Update thread message.
     */
    /*
    public function updateMessage(UpdateMessageRequest $request): JsonResponse
    {
        try {
            $message = $this->messageRepository->getById($request->message_id);

            if (is_null($message)) {
                $responseData = [];
                $responseData['message'] = 'Message not found';

                return $this->sendResponseError($responseData);
            }

            $user = Auth::user();
            if (! $user->isCurrentUser($message->getUserId())) {
                $responseData = [];
                $responseData['message'] = 'User not allowed to update this message';

                return $this->sendResponseError($responseData, 401);
            }

            if (! $message->isCreatedAtFewerThan5Minutes()) {
                $responseData = [];
                $responseData['message'] = 'User not allowed to update this message. Has passed more than five minutes since creation';

                return $this->sendResponseError($responseData, 401);
            }

            $message->setBody($request->body);
            $this->messageRepository->save($message);

            $responseData = [];
            $responseData['message'] = 'Message updated';

            return $this->sendResponse($responseData);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }*/
}
