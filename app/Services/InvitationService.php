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
        string $invitationType = 'private'
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
        string $invitationType = 'private'
    ): Invitation {
        // Check for existing invitation (excluding matching pending status)

        $existingInvitation = $this->findExistingInvitation($userId, $invitedBy, $conversationId, 'pending');
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
        ?string $status = null
    ): ?Invitation {

        return Invitation::where(function ($query) use ($userId, $invitedBy) {
            $query->where('user_id', $userId)
                ->where('invited_by', $invitedBy);
        })->orWhere(function ($query) use ($userId, $invitedBy) {
            $query->where('user_id', $invitedBy)
                ->where('invited_by', $userId);
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

        // Check for an existing invitation between user_id and invited_by
        $existingInvitation = $this->findExistingInvitation($invitation->user_id, $invitation->invited_by, null,
            'pending');

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
            $conversationService = new ConversationService;
            $newConversation = $conversationService->createPrivateChat(
                $existingInvitation->user_id,
                $existingInvitation->invited_by,
                $roomId
            );

            $existingInvitation->update([
                'conversation_id' => $newConversation->id,
            ]);
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
