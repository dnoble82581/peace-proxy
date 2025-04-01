<?php

namespace App\Events;

use App\Models\Invitation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationAcceptedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
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
    public function broadcastOn(): array
    {
        return [
            // Notify the inviter (sender) via their private user channel
            new PrivateChannel('user.'.$this->invitation->inviter_id),

            // Notify the invitee (receiver) via their private user channel
            new PrivateChannel('user.'.$this->invitation->invitee_id),
        ];
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith(): array
    {
        return [
            'invitationId' => $this->invitation->id,
            'status' => $this->invitation->status,
            'inviter_id' => $this->invitation->inviter_id,
            'invitee_id' => $this->invitation->invitee_id,
            'tenant_id' => $this->invitation->tenant_id,
            'token' => $this->invitation->token,
        ];
    }
}
