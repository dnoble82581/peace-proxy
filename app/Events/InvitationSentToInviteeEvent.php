<?php

namespace App\Events;

use App\Models\Invitation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationSentToInviteeEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Invitation $invitation;

    /**
     * Create a new event instance.
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user.'.$this->invitation->invitee_id);
    }

    public function broadcastWith(): array
    {
        return [
            'message' => 'Invitation received from '.$this->invitation->inviter->name,
            'type' => 'Invitation Sent',
            'invitationId' => $this->invitation->id,
            'status' => $this->invitation->status,
            'token' => $this->invitation->token,
            'inviter_id' => $this->invitation->inviter_id,
            'invitee_id' => $this->invitation->invitee_id,
            'tenant_id' => $this->invitation->tenant_id,
        ];
    }
}
