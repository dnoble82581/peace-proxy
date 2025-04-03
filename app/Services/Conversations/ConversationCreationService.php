<?php

namespace App\Services\Conversations;

use App\Models\Conversation;
use App\Models\Invitation;
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
        ]);
    }
}
