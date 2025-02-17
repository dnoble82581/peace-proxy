<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ParticipantLeavesChatEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public function __construct($roomId)
    {
        $this->roomId = $roomId;
    }

    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('chat.'.$this->roomId);
    }
}
