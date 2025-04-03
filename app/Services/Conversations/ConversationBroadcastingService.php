<?php

namespace App\Services\Conversations;

use App\Events\ConversationEvent;

class ConversationBroadcastingService
{
    public function __construct() {}

    public function broadcastNewConversation(int $conversationId, array $participants): void
    {
        foreach ($participants as $participant) {
            event(new ConversationEvent($conversationId, $participant));
        }

    }
}
