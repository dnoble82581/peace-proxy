<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WarningUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public function __construct($roomId)
    {
        $this->roomId = $roomId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('warning.'.$this->roomId),
        ];
    }
}
