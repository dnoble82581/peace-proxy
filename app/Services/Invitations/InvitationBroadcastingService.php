<?php

namespace App\Services\Invitations;

use App\Events\InvitationAcceptedEvent;
use App\Models\Invitation;

class InvitationBroadcastingService
{
    public function __construct() {}

    public function broadCastInvitationAccepted(Invitation $invitation)
    {
        event(new InvitationAcceptedEvent($invitation));
    }
}
