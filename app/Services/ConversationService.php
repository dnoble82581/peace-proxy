<?php

namespace App\Services;

use App\Models\Conversation;
use DB;
use Illuminate\Database\Eloquent\Collection;

class ConversationService
{
    public function fetchConversations(int $roomId, int $tenantId): Collection
    {
        return Conversation::where('room_id', $roomId)
            ->where('tenant_id', $tenantId)
            ->get();
    }

    public function addParticipantsToConversation($conversation, $users): void
    {
        // Get already existing participant IDs for this conversation
        $existingParticipants = DB::table('conversation_participants')
            ->where('conversation_id', $conversation->id)
            ->pluck('user_id')
            ->toArray();

        // Filter out users that are already participants
        $filteredUsers = $users->filter(function ($user) use ($existingParticipants) {
            return ! in_array($user->id, $existingParticipants);
        });

        // Map the filtered users to the participant data structure for insertion
        $bulkInsert = $filteredUsers->map(function ($user) use ($conversation) {
            return [
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'tenant_id' => $conversation->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // Insert the new participants
        DB::table('conversation_participants')->insertOrIgnore($bulkInsert); // Avoid duplicate inserts
    }

    public function createGroupChat(array $data): Conversation
    {
        return Conversation::firstOrCreate(
            [
                'type' => $data['type'],
                'room_id' => $data['room_id'],
                'tenant_id' => $data['tenant_id'],
            ],
            [
                'initiator_id' => $data['initiator_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
