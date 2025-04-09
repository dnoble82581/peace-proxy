<?php

namespace App\Events;

use App\Models\Invitation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvitationDeclinedToInviterEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?Invitation $invitation;

    public ?int $inviterId;

    public function __construct(?Invitation $invitation = null, ?int $inviterId = null)
    {
        $this->invitation = $invitation;
        $this->inviterId = $inviterId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        if ($this->inviterId) {
            return [new PrivateChannel('user.'.$this->inviterId)];
        }

        return [new PrivateChannel('user.'.$this->invitation->inviter_id)];
    }

    /**
     * Broadcast data specifically for the inviter.
     */
    public function broadcastWith(): array
    {
        if ($this->invitation) {
            return [
                'message' => $this->invitation->invitee->name.' has declined your invitation.',
                'type' => 'Invitation Received',
                'invitationId' => $this->invitation->id,
                'status' => $this->invitation->status,
                'tenant_id' => $this->invitation->tenant_id,
            ];
        }

        return [
            'message' => 'You are already in a conversation with this user',
            'status' => 'declined',
        ];

    }
}
