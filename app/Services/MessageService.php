<?php

namespace App\Services;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Room;
use App\Models\User;

class MessageService
{
    public function createMessage(Room $room, User $user, string $messageContent, int $conversationId): Message
    {
        // Creates the message in the database
        return $room->messages()->create([
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
            'room_id' => $room->id,
            'conversation_id' => $conversationId,
            'message' => $messageContent,
        ]);
    }

    public function broadcastMessage(Message $message): void
    {
        // Broadcast the message to other users
        broadcast(new NewMessageEvent($message));
    }
}
