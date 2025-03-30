<?php

namespace App\Services;

use App\Events\InvitationAcceptedEvent;
use App\Events\InvitationDeclinedEvent;
use App\Events\InvitationSent;
use App\Models\Invitation;
use Illuminate\Support\Collection;
use Throwable;

class InvitationService
{
    public function sendInvitations(
        ?int $conversationId,
        array $userIds,
        int $invitedBy,
        string $invitationType
    ): void {
        foreach ($userIds as $userId) {
            $invitation = $this->createOrUpdateInvitation(
                $userId,
                $conversationId,
                'pending',
                $invitedBy,
                $invitationType
            );

            // Broadcast the invitation event if a new invitation was created
            broadcast(new InvitationSent($invitation));
        }
    }

    public function createOrUpdateInvitation(
        int $userId,
        ?int $conversationId,
        string $status,
        int $invitedBy,
        string $invitationType
    ): Invitation {
        // Check for existing invitation (excluding matching pending status)
        $existingInvitation = $this->findExistingInvitation($userId, $invitedBy, $conversationId, 'pending',
            $invitationType);

        if (! $existingInvitation) {
            // Create a new invitation
            return Invitation::create([
                'user_id' => $userId,
                'conversation_id' => $conversationId,
                'status' => $status,
                'invited_by' => $invitedBy,
                'invitation_type' => $invitationType,
            ]);
        }

        $existingInvitation->update(['status' => 'pending']);

        // Return the existing invitation if no new one is created
        return $existingInvitation;
    }

    public function findExistingInvitation(
        int $userId,
        int $invitedBy,
        ?int $conversationId,
        ?string $status = null,
        ?string $invitationType = null
    ): ?Invitation {

        return Invitation::where(function ($query) use (
            $userId,
            $invitedBy,
            $conversationId,
            $status,
            $invitationType
        ) {
            if ($status) {
                $query->where('status', $status);
            }
            if ($invitationType) {
                $query->where('invitation_type', $invitationType);
            }
            $query->where('user_id', $userId)
                ->where('invited_by', $invitedBy);
            if ($conversationId) {
                $query->where('conversation_id', $conversationId);
            }
            if ($invitationType) {
                $query->where('invitation_type', $invitationType);
            }
        })->first();
    }

    /**
     * @throws Throwable
     */
    public function acceptInvitation(Invitation $invitation, $roomId): void
    {
        // Ensure the user is authorized to accept the invitation
        if ($invitation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $conversationService = new ConversationService;

        // Check for an existing invitation between user_id and invited_by
        $existingInvitation = $this->findExistingInvitation($invitation->user_id, $invitation->invited_by, null,
            'pending', $invitation->invitation_type);
        if ($existingInvitation) {
            // Update the status of the existing invitation
            $existingInvitation->update(['status' => 'accepted']);
        } else {
            // Create a new invitation if none exists
            $newInvitation = Invitation::create([
                'user_id' => $invitation->user_id,
                'conversation_id' => $invitation->conversation_id,
                'status' => 'accepted',
                'invited_by' => $invitation->invited_by,
                'invitation_type' => $invitation->invitation_type,
            ]);

            $existingInvitation = $newInvitation;
        }

        if ($existingInvitation->invitation_type === 'private') {
            $newConversation = $conversationService->createPrivateChat(
                $existingInvitation->user_id,
                $existingInvitation->invited_by,
                $roomId
            );
            $existingInvitation->update([
                'conversation_id' => $newConversation->id,
            ]);
        } else {
            $newConversation = $conversationService->createGroupChat([
                'type' => $existingInvitation->invitation_type,
                'name' => 'group-'.now()->timestamp,
                'room_id' => $roomId,
                'tenant_id' => $existingInvitation->user->tenant_id,
                'initiator_id' => $existingInvitation->user_id,
            ]);

            // Add the invited user to the conversation
            $conversationService->addParticipantsToConversation($newConversation, [$existingInvitation->user_id]);

        }

        broadcast(new InvitationAcceptedEvent($existingInvitation));
    }

    public function fetchPendingInvitations(): Collection
    {
        return Invitation::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with('conversation', 'inviter')
            ->get();
    }

    public function declineInvitation(Invitation $invitation): void
    {
        // Ensure the user is authorized to decline the invitation
        if ($invitation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Mark the invitation as declined
        $invitation->update(['status' => 'declined']);
        event(new InvitationDeclinedEvent($invitation));
    }
}
