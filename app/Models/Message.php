<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Message Attributes
     * $this->attributes['id'] - int - contains the message primary key (id)
     * $this->attributes['body'] - string - contains the message body
     * $this->attributes['thread_id'] - int - contains the referenced thread id
     * $this->attributes['user_id'] - int - contains the referenced user id
     * $this->attributes['created_at'] - timestamp - contains the message creation date
     * $this->attributes['updated_at'] - timestamp - contains the message update date
     * $this->thread - Thread - contains the associated Thread
     * $this->user - User - contains the associated User
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'body',
        'thread_id',
        'user_id',
    ];

    /* Getters and setters */

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getBody(): string
    {
        return $this->attributes['body'];
    }

    public function setBody(string $body): void
    {
        $this->attributes['body'] = $body;
    }

    public function getUserId(): int
    {
        return $this->attributes['user_id'];
    }

    public function setUserId(int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    public function getThreadId(): int
    {
        return $this->attributes['thread_id'];
    }

    public function setThreadId(int $threadId): void
    {
        $this->attributes['thread_id'] = $threadId;
    }

    public function getCreatedAt(): string
    {
        return $this->attributes['created_at'];
    }

    public function getUpdatedAt(): string
    {
        return $this->attributes['updated_at'];
    }

    /* Relationships */

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function getThread(): Thread
    {
        return $this->thread;
    }

    public function setThread(Thread $thread): void
    {
        $this->thread = $thread;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /* Other methods */

    public function isCreatedAtFewerThan5Minutes(): bool
    {
        $currentTimeMinusFiveMinutes = Carbon::now()->subMinutes(5)->toDateTimeString();

        return $this->getCreatedAt() >= $currentTimeMinusFiveMinutes ? true : false;
    }
}
