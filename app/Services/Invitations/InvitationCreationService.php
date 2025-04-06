<?php

namespace App\Services\Invitations;

use App\Events\InvitationSent;
use App\Models\Invitation;
use App\Models\Room;
use App\Models\User;
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
}
