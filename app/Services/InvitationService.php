<?php

namespace App\Services;

use App\Events\InvitationDeclinedEvent;
use App\Events\InvitationSent;
use App\Models\Conversation;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

class InvitationService
{
    public function sendPrivateInvitation($data): RedirectResponse
    {
        try {
            $invitation = Invitation::create([
                'inviter_id' => $data['inviter_id'],
                'invitee_id' => $data['invitee_id'],
                'tenant_id' => $data['tenant_id'],
                'room_id' => $data['room_id'],
                'type' => 'private',
                'status' => 'pending',
                'token' => Str::random(40),
            ]);
            event(new InvitationSent($invitation));

            return redirect()->back()->with('success', 'Invitation sent successfully!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Integrity constraint violation
                return redirect()->back()->with('error', 'User already invited!');
            }
            throw $e; // Re-throw other exceptions
        }
    }

    public function sendGroupInvitations(array $data, string $type) {}

    public function fetchPendingInvitations(User $user): Collection
    {
        return $user->receivedInvitations()->where('status', 'pending')->get();
    }

    //	See if you need this

    /**
     * @throws Throwable
     */
    public function acceptPrivateInvitation($token): Conversation
    {
        // Fetch the pending invitation
        $invitation = $this->findExistingInvitation($token);
        // Mark the invitation as accepted
        $invitation->update(['status' => 'accepted']);

        $conversationService = new ConversationService;

        $conversation = $conversationService->createPrivateChat($invitation);

        $data = [
            'sender_id' => $invitation->inviter_id,
            'receiver_id' => $invitation->invitee_id,
        ];
        $conversationService->addParticipantsToConversation($conversation, $data);

        $conversationService->broadcastNewConversation($conversation->id, $data);

        $invitation->update(['conversation_id' => $conversation->id]);

        return $conversation;

    }

    public function findExistingInvitation($token): ?Invitation
    {
        return Invitation::where('token', $token)->where('status', 'pending')->firstorFail();
    }

    public function declineInvitation(Invitation $invitation): void
    {
        // Ensure the user is authorized to decline the invitation
        if ($invitation->invitee_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Mark the invitation as declined
        $invitation->update(['status' => 'declined']);
        event(new InvitationDeclinedEvent($invitation));
    }
}
