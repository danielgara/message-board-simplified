<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    /**
     * Thread Attributes
     * $this->attributes['id'] - int - contains the thread primary key (id)
     * $this->attributes['title'] - string - contains the thread title
     * $this->attributes['created_at'] - timestamp - contains the thread creation date
     * $this->attributes['updated_at'] - timestamp - contains the thread update date
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

    /* Getters and setters */

    public function getId(): int
    {
        return $this->attributes['id'];
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getTitle(): string
    {
        return $this->attributes['title'];
    }

    public function setTitle(string $title): void
    {
        $this->attributes['title'] = $title;
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

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages($messages): void
    {
        $this->messages = $messages;
    }
}
