<?php

namespace App\Services;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;

class MessageService
{
    public function createMessage(
        Room $room,
        Model $model,
        string $messageContent,
        int $conversationId,
        ?int $recipientId
    ): Message {
        // Creates the message in the database
        return $model->messages()->create([
            'tenant_id' => $model->tenant_id,
            'room_id' => $room->id,
            'recipient' => $recipientId ?? null,
            'message_status' => 'sent',
            'message_type' => 'chat',
            'sent_at' => now(),
            'conversation_id' => $conversationId,
            'message' => $messageContent,
            'user_id' => auth()->user()->id,
        ]);
    }

    public function broadcastMessage(Message $message): void
    {
        // Broadcast the message to other users
        broadcast(new NewMessageEvent($message));
    }
}
