<?php

namespace App\Services\Messages;

use App\Services\Conversations\ConversationFetchingService;
use Illuminate\Support\Facades\Auth;

class MessageUpdatingService
{
    public function __construct() {}

    public function markUserMessagesAsRead($conversationId)
    {
        $conversationFetchingService = new ConversationFetchingService;
        $conversation = $conversationFetchingService->fetchConversationById($conversationId);

        // Perform a bulk update for all unread messages not sent by the current user
        $conversation->messages()
            ->where('senderable_id', '!=', Auth::id()) // Exclude user's own messages
            ->where('is_read', false) // Only unread messages
            ->update(['is_read' => true]);

    }
}
