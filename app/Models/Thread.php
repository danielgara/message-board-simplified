<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * Thread Attributes
     * $this->id - int - contains the thread primary key (id)
     * $this->title - string - contains the thread title
     * $this->created_at - timestamp - contains the thread creation date
     * $this->updated_at - timestamp - contains the thread update date
     * $this->messages - Messages[] - contains the associated messages
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    /* Relationship to messages */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public static function getThreadsByUserId(int $userId): ?Collection
    {
        return Thread::whereHas('messages', function (Builder $query) use ($userId) {
            $query->where('user_id', '=', $userId);
        })->get();
    }
}
