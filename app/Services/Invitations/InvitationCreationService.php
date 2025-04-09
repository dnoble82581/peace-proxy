<?php

namespace App\Services\Invitations;

use App\Events\InvitationDeclinedToInviterEvent;
use App\Events\InvitationSent;
use App\Events\InvitationSentToInviteeEvent;
use App\Events\InvitationSentToInviterEvent;
use App\Models\Invitation;
use App\Models\Room;
use App\Models\User;
use App\Services\Conversations\ConversationFetchingService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class InvitationCreationService
{
    public function __construct() {}

    /**
     * @throws Throwable
     */
    public function createGroupInvitation(User $user, array $invitees, Room $room): string
    {

        $groupToken = (string) Str::uuid();

        DB::beginTransaction();

        try {
            foreach ($invitees as $invitee) {
                $invitee = User::find($invitee);

                if (! $invitee) {
                    continue;
                }

                $invitation = Invitation::updateOrCreate(
                    [
                        'invitee_id' => $invitee->id,
                        'groupToken' => $groupToken,
                    ],
                    [
                        'inviter_id' => $user->id,
                        'status' => 'pending',
                        'room_id' => $room->id,
                        'token' => (string) Str::uuid(),
                        'type' => 'group',
                    ]
                );
                event(new InvitationSent($invitation));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $groupToken;
    }

    public function sendPrivateInvitation($data): RedirectResponse
    {
        $conversationFetchingService = new ConversationFetchingService;

        // Check if the inviter is already in a private conversation with the invitee
        $privateConversationExists = $conversationFetchingService->fetchUserConversations(User::find($data['inviter_id']))
            ->filter(function ($conversation) use ($data) {
                // Check if the conversation is private and involves both users
                return $conversation->type === 'private' &&
                    $conversation->participants->contains('id', $data['invitee_id']);
            })->isNotEmpty();

        // If a private conversation already exists, send feedback
        if ($privateConversationExists) {
            event(new InvitationDeclinedToInviterEvent(
                invitation: null,
                inviterId: $data['inviter_id'],
            ));

            return redirect()->back()->with('info', 'You are already in a private conversation with this user.');
        }

        // Proceed to create the private invitation if no private conversation exists
        try {
            $invitation = Invitation::create([
                'inviter_id' => $data['inviter_id'],
                'invitee_id' => $data['invitee_id'],
                'tenant_id' => $data['tenant_id'],
                'room_id' => $data['room_id'],
                'type' => $data['type'],
                'status' => $data['status'],
                'token' => Str::random(40),
            ]);

            event(new InvitationSentToInviteeEvent($invitation));
            event(new InvitationSentToInviterEvent($invitation));

            return redirect()->back()->with('success', 'Invitation sent successfully!');
        } catch (QueryException $e) {
            if ($e->getCode() === '23000') { // Integrity constraint violation
                return redirect()->back()->with('error', 'User already invited!');
            }
            throw $e; // Re-throw other exceptions
        }
    }
}
