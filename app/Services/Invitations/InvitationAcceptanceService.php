<?php

namespace App\Services\Invitations;

use App\Events\InvitationDeclinedToInviteeEvent;
use App\Events\InvitationDeclinedToInviterEvent;
use App\Models\Conversation;
use App\Models\Invitation;
use App\Services\Conversations\ConversationBroadcastingService;
use App\Services\Conversations\ConversationCreationService;
use App\Services\Conversations\ParticipantService;
use Throwable;

class InvitationAcceptanceService
{
    public function __construct() {}

    /**
     * @throws Throwable
     */
    public function acceptInvitation($token)
    {

        $invitationFetchingService = new InvitationFetchingService;
        $invitation = $invitationFetchingService->fetchInvitationByToken($token);

        if ($invitation->type === 'private') {
            return $this->acceptPrivateInvitation($invitation);
        } else {
            return $this->acceptGroupInvitation($invitation);
        }
    }

    public function acceptPrivateInvitation(Invitation $invitation): Conversation
    {
        // Mark the invitation as accepted
        $invitation->update(['status' => 'accepted']);

        $conversationCreationService = app(ConversationCreationService::class);

        $conversation = $conversationCreationService->createPrivateChat($invitation);

        $participants = [
            'sender_id' => $invitation->inviter_id,
            'receiver_id' => $invitation->invitee_id,
        ];
        $participantService = new ParticipantService;
        $participantService->addParticipantsToConversation($conversation, $participants);

        $conversationBroadcastingService = new ConversationBroadcastingService;
        $conversationBroadcastingService->broadcastNewConversation($conversation->id, $participants);

        $invitationBroadcastingService = new InvitationBroadcastingService;
        $invitationBroadcastingService->broadCastInvitationAccepted($invitation);

        $invitation->update(['conversation_id' => $conversation->id]);

        return $conversation;
    }

    /**
     * @throws Throwable
     */
    public function acceptGroupInvitation(Invitation $invitation)
    {
        $invitation->update(['status' => 'accepted']);
        $invitationBroadcastingService = new InvitationBroadcastingService;
        $invitationBroadcastingService->broadCastInvitationAccepted($invitation);

        $acceptedInvitations = Invitation::where('invitations.groupToken', $invitation->groupToken)
            ->where('status', 'accepted')
            ->get();

        if ($acceptedInvitations->count() >= 2) {

            $participants = $acceptedInvitations->pluck('invitee_id')->toArray();
            $participants[] = $invitation->inviter_id;
            $conversationCreationService = app(ConversationCreationService::class);
            $newGroupConversation = $conversationCreationService->createGroupChat($invitation, $participants);

            foreach ($acceptedInvitations as $acceptedInvitation) {
                $acceptedInvitation->update(['conversation_id' => $newGroupConversation->id]);
            }

            return $newGroupConversation;
        }

        return null;
    }

    public function declineInvitation(Invitation $invitation): void
    {
        $invitation->update(['status' => 'declined']);

        event(new InvitationDeclinedToInviterEvent($invitation));

        // Fire event for the invitee
        event(new InvitationDeclinedToInviteeEvent($invitation));

    }
}
