<?php

namespace App\Events;

use App\Models\Invitation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationDeclinedToInviteeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Invitation $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [new PrivateChannel('user.'.$this->invitation->invitee_id)];
    }

    /**
     * Broadcast data specifically for the invitee.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => 'You have declined the invitation from '.$this->invitation->inviter->name.'.',
            'invitationId' => $this->invitation->id,
            'status' => $this->invitation->status,
            'tenant_id' => $this->invitation->tenant_id,
        ];
    }
}
