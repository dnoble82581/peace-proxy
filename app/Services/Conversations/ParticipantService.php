<?php

namespace App\Services\Conversations;

use App\Events\UserLeavesPrivateChatEvent;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\User;
use Exception;

class ParticipantService
{
    public function __construct() {}

    public function addParticipantsToConversation(Conversation $conversation, array $users): void
    {
        foreach ($users as $user) {
            $conversation->participants()->attach($user, [
                'joined_at' => now(), 'status' => 'accepted', 'tenant_id' => $conversation->tenant_id,
            ]);
        }
    }

    public function fetchOtherParticipantName(Conversation $conversation, $user)
    {
        $otherParticipants = $conversation->participants()
            ->where('name', '!=', $user->name)
            ->get();

        return $otherParticipants->isNotEmpty() ? $otherParticipants[0]->name : null;
    }

    public function checkUserIsInConversation($userId, $convoToCheckId): bool
    {
        return ConversationParticipant::where('conversation_id', $convoToCheckId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * @throws Exception
     */
    public function userLeavesConversation($userId, $conversationId): void
    {
        // Retrieve the conversation
        $conversation = Conversation::find($conversationId);

        if (! $conversation) {
            // If the conversation doesn't exist, throw an error or return early
            throw new Exception('Conversation not found.');
        }

        // Check if the user is a participant in the conversation
        $isParticipant = $conversation->participants()->where('user_id', $userId)->exists();

        if (! $isParticipant) {
            // If the user is not a participant, return appropriate feedback
            throw new Exception('User is not a part of this conversation.');
        }

        // Detach the user from the conversation
        $conversation->participants()->detach($userId);

        if ($conversation->type == 'private') {
            $user = User::find($userId);
            $otherUser = $this->fetchOtherParticipant($conversation, $user);
            $conversation->participants()->detach($otherUser->id);
            event(new UserLeavesPrivateChatEvent($userid, $conversationId));
        }

    }

    public function fetchOtherParticipant(Conversation $conversation, $user)
    {
        $otherParticipants = $conversation->participants()
            ->where('name', '!=', $user->name)
            ->get();

        return $otherParticipants->isNotEmpty() ? $otherParticipants[0] : null;
    }
}
