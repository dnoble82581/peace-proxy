<?php

namespace App\Services;

use App\Events\InvitationDeclinedEvent;
use App\Events\InvitationSent;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

class InvitationService
{
    public function sendInvitation($data): RedirectResponse
    {
        try {
            $invitation = Invitation::create([
                'inviter_id' => $data['inviter_id'],
                'invitee_id' => $data['invitee_id'],
                'tenant_id' => $data['tenant_id'],
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

    public function fetchPendingInvitations(User $user): Collection
    {
        return $user->receivedInvitations()->where('status', 'pending')->get();
    }

    //	See if you need this

    /**
     * @throws Throwable
     */
    public function acceptInvitation($token): void
    {
        $invitation = $this->findExistingInvitation($token);
        $invitation->update(['status' => 'accepted']);
        if ($invitation->conversation_id) {
            // Group conversation: Add to existing conversation
            $invitation->conversation->participants()->attach($invitation->invitee_id, [
                'joined_at' => now(),
                'status' => 'accepted',
                'tenant_id' => $invitation->tenant_id,
            ]);
        } else {
            // Private conversation: Create new
            $conversationService = new ConversationService;
            $newConversation = $conversationService->createConversation($invitation, 'private');
            $conversationService->addParticipantsToConversation($newConversation,
                [$invitation->inviter_id, $invitation->invitee_id]);
            $invitation->update(['conversation_id' => $newConversation->id]);
        }

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
