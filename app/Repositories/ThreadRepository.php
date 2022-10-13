<?php

namespace App\Repositories;

use App\Interfaces\ThreadRepositoryInterface;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ThreadRepository implements ThreadRepositoryInterface
{
    public function save(Thread $thread): Thread
    {
        $thread->save();

        return $thread;
    }

    public function getById(int $threadId): ?Thread
    {
        return Thread::find($threadId);
    }

    public function getThreadsByUserId(int $userId): ?Collection
    {
        return Thread::whereHas('messages', function (Builder $query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->get();
    }
}
