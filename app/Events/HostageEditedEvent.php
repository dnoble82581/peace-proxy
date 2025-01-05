<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HostageEditedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public int $hostageId;

    public function __construct($roomId, $hostageId)
    {
        $this->roomId = $roomId;
        $this->hostageId = $hostageId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('hostage.'.$this->roomId),
        ];
    }
}
