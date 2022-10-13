<?php

namespace App\Repositories;

use App\Interfaces\MessageRepositoryInterface;
use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageRepository implements MessageRepositoryInterface
{
    public function save(Message $message): Message
    {
        $message->save();

        return $message;
    }

    public function getByThreadId(int $threadId): ?Collection
    {
        return Message::where('thread_id', '=', $threadId)->orderBy('created_at', 'desc')->get();
    }

    public function getById(int $messageId): ?Message
    {
        return Message::find($messageId);
    }

    public function getMessagesByUserIdAndThreadIdAndSearchTerm(int $userId, int $threadId, string $searchTerm): ?Collection
    {
        return Message::where('user_id', '=', $userId)
                    ->where('thread_id', '=', $threadId)
                    ->where('body', 'LIKE', '%'.$searchTerm.'%')
                    ->get();
    }
}
