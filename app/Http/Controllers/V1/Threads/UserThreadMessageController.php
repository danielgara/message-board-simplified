<?php

namespace App\Http\Controllers\V1\Threads;

use App\DTOs\MessageDTO;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Http\Resources\MessageResource;
use App\Interfaces\MessageRepositoryInterface;
use App\Interfaces\ThreadRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserThreadMessageController extends BaseController
{
    private ThreadRepositoryInterface $threadRepository;

    private MessageRepositoryInterface $messageRepository;

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository, ThreadRepositoryInterface $threadRepository, MessageRepositoryInterface $messageRepository)
    {
        $this->userRepository = $userRepository;
        $this->threadRepository = $threadRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Create a message in storage and returns it.
     */
    public function createMessage(CreateMessageRequest $request): JsonResponse
    {
        try {
            $messageObject = MessageDTO::fromRequest($request);
            $message = $this->messageRepository->save($messageObject);

            $responseData = [];
            $responseData['message'] = new MessageResource($message);

            return $this->sendResponse($responseData, 201);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }

    /**
     * Get threads in which user has parcipated.
     */
    public function getUserThreads(int $userId): JsonResponse
    {
        try {
            $user = $this->userRepository->getById($userId);

            if (is_null($user)) {
                $responseData = [];
                $responseData['message'] = 'User not found';

                return $this->sendResponseError($responseData);
            }

            $threads = $this->threadRepository->getThreadsByUserId($userId);

            if (count($threads) == 0) {
                $responseData = [];
                $responseData['message'] = 'Threads not found';

                return $this->sendResponseError($responseData);
            }

            $responseData = [];
            $responseData['threads'] = $threads;

            return $this->sendResponse($responseData);
        } catch (Throwable $th) {
            $responseData = [];
            $responseData['message'] = $th->getMessage();

            return $this->sendResponseError($responseData, 500);
        }
    }

    /**
     * Update thread message.
     */
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
    }
}
