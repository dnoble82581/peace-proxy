<?php

namespace App\Services\Conversations;

use App\Models\Conversation;
use App\Models\Invitation;
use App\Models\Room;
use App\Models\User;
use App\Services\PhoneNumberService;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConversationCreationService
{
    protected ParticipantService $participantService;

    public function __construct(ParticipantService $participantService)
    {
        $this->participantService = $participantService;
    }

    /**
     * @throws Throwable
     */
    public function createGroupChat(Invitation $invitation, array $participants): Conversation
    {
        DB::beginTransaction();

        try {
            $conversation = Conversation::create([
                'type' => 'group',
                'name' => 'Group',
                'room_id' => $invitation->room_id,
                'tenant_id' => $invitation->tenant_id,
                'token' => $invitation->groupToken,
                'status' => 'accepted',
            ]);

            DB::commit();
            $this->participantService->addParticipantsToConversation($conversation, $participants);

        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return $conversation;
    }

    public function createPublicChat(array $data, array $users = []): Conversation
    {
        $existingConversation = Conversation::where([
            'type' => $data['type'],
            'name' => $data['name'],
            'room_id' => $data['room_id'],
            'token' => $data['token'],
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
            'room_id' => $data['room_id'],
            'token' => $data['token'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->participantService->addParticipantsToConversation($conversation, $users);

        return $conversation;
    }

    public function createPrivateChat(Invitation $invitation): Conversation
    {
        return Conversation::create([
            'type' => 'private',
            'name' => 'Private',
            'room_id' => $invitation->room_id,
            'tenant_id' => $invitation->tenant_id,
            'status' => 'accepted',
            'token' => $invitation->token,
        ]);
    }

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

            $this->participantService->addParticipantsToConversation($newConversation, [
                $authUser->id,
                $phoneNumber, // Represent the phone number as a virtual participant
            ]);

            return $newConversation;
        });
    }
}
