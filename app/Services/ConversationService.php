<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Invitation;
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
            'tenant_id' => $data['tenant_id'],
        ])->first();
        // If an existing conversation is found, return it
        if ($existingConversation) {
            return $existingConversation;
        }
        // Otherwise, create a new conversation
        $conversation = Conversation::create([
            'type' => $data['type'],
            'name' => $data['name'],
            'tenant_id' => $data['tenant_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Add participants to the conversation

        $this->addParticipantsToConversation($conversation, $users);

        return $conversation;

    }

    /**
     * @throws Exception
     */
    public function addParticipantsToConversation(Conversation $conversation, array $users): void
    {
        foreach ($users as $user) {
            $conversation->participants()->attach($user, [
                'joined_at' => now(), 'status' => 'accepted', 'tenant_id' => $conversation->tenant_id,
            ]);
        }

    }

    /**
     * @throws Throwable
     */
    public function createConversation(Invitation $invitation, $type): Conversation
    {
        return Conversation::create([
            'type' => $type,
            'tenant_id' => $invitation->tenant_id,
        ]);
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
