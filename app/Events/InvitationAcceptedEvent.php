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
            new PrivateChannel('user.'.$this->invitation->invited_by),

            // Notify the invitee (receiver) via their private user channel
            new PrivateChannel('user.'.$this->invitation->user_id),
        ];
    }

    /**
     * Data to broadcast with the event.
     */
    public function broadcastWith()
    {
        return [
            'invitationId' => $this->invitation->id,
            'status' => $this->invitation->status,
            'conversationId' => $this->invitation->conversation_id,
        ];
    }
}
