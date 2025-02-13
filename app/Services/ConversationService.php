<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Room;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Collection;

class ConversationService
{
    protected InvitationService $invitationService;

    public function __construct()
    {
        $this->invitationService = new InvitationService;
    }

    public function fetchConversations(int $roomId, int $tenantId, int $userId): Collection
    {
        return Conversation::where('room_id', $roomId)
            ->where('tenant_id', $tenantId)
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();
    }

    public function createGroupChat(array $data): Conversation
    {
        return Conversation::firstOrCreate(
            [
                'type' => $data['type'],
                'name' => $data['name'],
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

    public function createPrivateChat(array $userIds, $roomId, $userId): Conversation
    {
        $authUser = User::findOrfail($userId);
        $room = Room::findOrfail($roomId);

        // Ensure the initiator is not duplicated in the participants
        $allParticipants = array_unique(array_merge($userIds, [$authUser->id]));
        sort($allParticipants);

        // Use a database lock to prevent duplicate conversation creation
        return DB::transaction(function () use ($allParticipants, $room, $authUser) {
            // Check if a conversation with these exact participants exists
            $existingConversation = Conversation::query()
                ->private() // Assuming `private()` is a scope for private conversations
                ->whereHas('participants', function ($query) use ($allParticipants) {
                    // Ensure the same set of participants exist
                    $query->select('conversation_id')
                        ->groupBy('conversation_id')
                        ->havingRaw('COUNT(user_id) = ?', [count($allParticipants)])
                        ->whereIn('user_id', $allParticipants);
                }, '=', 1)
                ->lockForUpdate() // Prevent race conditions by locking the rows
                ->first();

            if ($existingConversation) {
                // Return the already existing conversation
                return $existingConversation;
            }

            // Create a new conversation if none exists
            return Conversation::create([
                'name' => 'Private Conversation',
                'type' => 'private',
                'initiator_id' => $authUser->id,
                'room_id' => $room->id,
                'tenant_id' => $room->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }

    public function addParticipantsToConversation($conversation, $users): void
    {
        $existingParticipants = DB::table('conversation_participants')
            ->where('conversation_id', $conversation->id)
            ->pluck('user_id')
            ->toArray();

        $filteredUsers = $users->filter(function ($user) use ($existingParticipants) {
            return ! in_array($user->id, $existingParticipants);
        });

        $bulkInsert = $filteredUsers->map(function ($user) use ($conversation) {
            return [
                'conversation_id' => $conversation->id,
                'user_id' => $user->id,
                'tenant_id' => $conversation->tenant_id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        DB::table('conversation_participants')->insertOrIgnore($bulkInsert);
    }

    public function sendInvitations(?Conversation $conversation, array $userIds, int $invitedBy): void
    {
        // Delegate the logic to InvitationService
        $this->invitationService->sendInvitations(
            $conversation?->id,
            $userIds,
            $invitedBy,
            $conversation ? $conversation->type : 'private'
        );
    }
}
