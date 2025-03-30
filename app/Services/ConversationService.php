<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Room;
use App\Models\User;
use DB;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

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
            ->where('is_active', true)
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['participants', 'participants.user']) // Eager-load participants and their user relations
            ->get();
    }

    /**
     * @throws Exception
     */
    public function createGroupChat(array $data, array $users = []): Conversation
    {
        $existingConversation = Conversation::where([
            'type' => $data['type'],
            'name' => $data['name'],
            'room_id' => $data['room_id'],
            'tenant_id' => $data['tenant_id'],
            'initiator_id' => $data['initiator_id'],
        ])->first();
        // If an existing conversation is found, return it
        if ($existingConversation) {
            $existingConversation->update(['is_active' => true]);

            return $existingConversation;
        }

        // Otherwise, create a new conversation
        $conversation = Conversation::create([
            'type' => $data['type'],
            'name' => $data['name'],
            'room_id' => $data['room_id'],
            'tenant_id' => $data['tenant_id'],
            'initiator_id' => $data['initiator_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Add participants to the conversation
        if (! empty($users)) {
            $this->addParticipantsToConversation($conversation, $users);
        }

        return $conversation;

    }

    /**
     * @throws Exception
     */
    public function addParticipantsToConversation($conversation, $users): void
    {
        // Step 1: Fetch current participants' user IDs for the given conversation
        $currentParticipants = $conversation->participants()->pluck('user_id')->toArray();

        if (is_array($users)) {
            $userIds = array_diff($users, $currentParticipants);
        } else {
            $userIds = $users->pluck('id')->toArray();

        }
        // Step 2: Filter out users that are already in the conversation
        $newUsers = array_diff($userIds, $currentParticipants);

        // Step 3: Attach only the new users to the conversation
        foreach ($newUsers as $userId) {
            $conversation->participants()->create([
                'user_id' => $userId,
            ]);
        }
    }

    /**
     * @throws Throwable
     */
    public function createPrivateChat($authUserId, $otherUserId, $roomId): Conversation
    {
        // Ensure both user IDs are included and sorted for consistency
        $userIds = [$authUserId, $otherUserId];
        sort($userIds);

        return DB::transaction(function () use ($userIds, $authUserId, $roomId) {
            // Query for existing conversation with these participants
            $existingConversation = Conversation::query()
                ->where('type', 'private')
                ->where('room_id', $roomId)
                ->whereHas('participants', function ($query) use ($userIds) {
                    $query->select('conversation_id')
                        ->groupBy('conversation_id')
                        ->havingRaw('COUNT(user_id) = 2') // Ensure only 2 users
                        ->whereIn('user_id', $userIds); // Match both users
                })
                ->lockForUpdate() // Prevent race condition
                ->first();

            // If the conversation exists, just return it
            if ($existingConversation) {
                $existingConversation->update(['is_active' => true]);

                return $existingConversation;
            }

            // Create a new conversation if it doesn't exist
            $conversation = Conversation::create([
                'name' => 'private-'.now()->timestamp,
                'type' => 'private',
                'initiator_id' => $authUserId,
                'room_id' => $roomId,
                'is_active' => true,
                'tenant_id' => Room::findOrFail($roomId)->tenant_id, // Assuming Room model has a tenant_id
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add both users as participants
            $this->addParticipantsToConversation($conversation, $userIds);

            return $conversation;
        });
    }

    /**
     * @throws Throwable
     */
    public function createSmsConversation(string $phoneNumber, int $roomId, int $userId): Conversation
    {
        $authUser = User::findOrFail($userId); // Authenticated user
        $room = Room::findOrFail($roomId);     // Room context for the conversation
        $phoneNumberService = new PhoneNumberService;

        $phoneNumber = $phoneNumberService->formatToE164($phoneNumber);

        // Use a database transaction to ensure atomicity
        return DB::transaction(function () use ($phoneNumber, $room, $authUser) {
            // Check if an SMS conversation with the specific phone number already exists
            $existingConversation = Conversation::query()
                ->where('type', 'sms')               // Sms-specific type
                ->where('room_id', $room->id)       // Belongs to the same room
                ->where('tenant_id', $room->tenant_id) // Same tenant
                ->where('name', $phoneNumber)       // Identify by phone number
                ->first();

            if ($existingConversation) {
                return $existingConversation; // Return the existing SMS conversation
            }

            // Create a new SMS conversation
            $newConversation = Conversation::create([
                'type' => 'sms',
                'name' => $phoneNumber, // Use the phone number as the conversation name
                'room_id' => $room->id,
                'tenant_id' => $room->tenant_id,
                'subject_id' => $room->subject->id,
                'initiator_id' => $authUser->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add authenticated user and phone number as participants
            $this->addParticipantsToConversation($newConversation, [
                $authUser->id,
                $phoneNumber, // Represent the phone number as a virtual participant
            ]);

            return $newConversation;
        });
    }
}
