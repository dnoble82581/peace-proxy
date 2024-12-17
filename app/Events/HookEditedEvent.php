<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event fired when a hook is edited.
 * Implements real-time broadcasting to notify others in the room about the changes.
 */
class HookEditedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The ID of the hook that was edited.
     */
    public int $hookId;

    /**
     * The ID of the room associated with the hook.
     */
    public int $roomId;

    /**
     * Constructor to initialize the event with the hook and room IDs.
     *
     * @param  int  $hookId  The ID of the hook that was changed.
     * @param  int  $roomId  The ID of the room associated with the hook.
     */
    public function __construct(int $hookId, int $roomId)
    {
        $this->hookId = $hookId;
        $this->roomId = $roomId;
    }

    /**
     * Defines the broadcast channels associated with this event.
     * Transmits the event to all users in the specified room's presence channel.
     *
     * @return array The list of channels this event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('hook.'.$this->roomId),
        ];
    }
}
