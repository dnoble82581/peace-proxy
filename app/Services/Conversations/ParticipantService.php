<?php

namespace App\Services\Conversations;

use App\Models\Conversation;

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

        return $otherParticipants[0]->name;
    }
}
