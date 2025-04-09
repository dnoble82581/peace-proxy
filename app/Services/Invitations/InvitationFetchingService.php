<?php

namespace App\Services\Invitations;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Collection;

class InvitationFetchingService
{
    public function __construct() {}

    public function fetchPendingInvitations(User $user): Collection
    {
        return $user->receivedInvitations()->where('status', 'pending')->get();
    }

    public function fetchInvitationByToken($token): Invitation
    {
        return Invitation::where('token', $token)->first();
    }

    public function fetchInvitation(array $data): ?Invitation
    {
        $existingInvitation = Invitation::where([
            'tenant_id' => $data['tenant_id'],
            'room_id' => $data['room_id'],
            'invitee_id' => $data['invitee_id'],
            'inviter_id' => $data['inviter_id'],
            'type' => $data['type'],
            'status' => $data['status'],
        ])->first();
        if ($existingInvitation) {
            return $existingInvitation;
        }

        return null;
    }
}
