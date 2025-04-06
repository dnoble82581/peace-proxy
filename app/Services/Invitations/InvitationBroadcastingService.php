<?php

namespace App\Services\Invitations;

use App\Events\InvitationAcceptedEvent;
use App\Events\InvitationDeclinedEvent;
use App\Models\Invitation;

class InvitationBroadcastingService
{
    public function __construct() {}

    public function broadCastInvitationAccepted(Invitation $invitation): void
    {
        event(new InvitationAcceptedEvent($invitation));
    }

    public function broadcastInvitationDeclined(Invitation $invitation): void
    {
        event(new InvitationDeclinedEvent($invitation));
    }
}
