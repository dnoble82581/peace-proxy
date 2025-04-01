<?php

namespace App\Services;

use App\Events\NewMessageEvent;
use App\Models\Message;

class MessageService
{
    public function createMessage(array $data): Message
    {
        // Creates the message in the database
        return Message::create($data);
    }

    public function broadcastMessage(Message $message): void
    {
        // Broadcast the message to other users
        broadcast(new NewMessageEvent($message));
    }
}
