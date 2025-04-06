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

    public function fetchInvitation($token): Invitation
    {
        return Invitation::where('token', $token)->first();
    }
}
