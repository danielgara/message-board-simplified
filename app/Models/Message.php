<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Message Attributes
     * $this->attributesid - int - contains the message primary key (id)
     * $this->body - string - contains the message body
     * $this->thread_id - int - contains the referenced thread id
     * $this->user_id - int - contains the referenced user id
     * $this->created_at - timestamp - contains the message creation date
     * $this->updated_at - timestamp - contains the message update date
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

    /* Relationship to thread */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /* Relationship to user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isCreatedAtFewerThan5Minutes(): bool
    {
        $currentTimeMinusFiveMinutes = Carbon::now()->subMinutes(5)->toDateTimeString();

        return $this->created_at >= $currentTimeMinusFiveMinutes ? true : false;
    }

    public static function getMessagesByUserIdAndThreadIdAndSearchTerm(int $userId, int $threadId, string $searchTerm): ?Collection
    {
        return Message::where('user_id', '=', $userId)
                    ->where('thread_id', '=', $threadId)
                    ->where('body', 'LIKE', '%'.$searchTerm.'%')
                    ->get();
    }
}
