<?php

namespace App\Services;

use App\Events\InvitationDeclinedEvent;
use App\Events\InvitationSent;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Collection;

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
        $existingInvitation = $this->findExistingInvitation($userId, $conversationId);

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

        // Return the existing invitation if no new one is created
        return $existingInvitation;
    }

    public function findExistingInvitation(int $userId, ?int $conversationId, ?string $status = null): ?Invitation
    {
        $query = Invitation::where([
            'user_id' => $userId,
            'conversation_id' => $conversationId,
            'status' => 'pending',
        ]);

        // Optionally filter by status if provided
        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->first();
    }

    public function acceptInvitation(Invitation $invitation, $roomId): void
    {
        // Ensure the user is authorized to accept the invitation
        if ($invitation->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $conversationService = new ConversationService;
        $newConversation = $conversationService->createPrivateChat([$invitation->user_id], $roomId,
            auth()->user()->id);
        $invitation->update(['conversation_id' => $newConversation->id]);

        //			 Add the user as a participant in the conversation
        $sender = User::findOrFail($invitation->invited_by);
        $target = User::findOrFail($invitation->user_id);
        $usersToAdd = collect([$sender, $target]);

        $conversationService->addParticipantsToConversation($newConversation, $usersToAdd);
        // Mark the invitation as accepted
        $invitation->update(['status' => 'accepted']);
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
