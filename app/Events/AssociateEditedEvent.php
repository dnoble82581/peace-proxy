<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssociateEditedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public int $associateId;

    public function __construct($roomId, $associateId)
    {
        $this->roomId = $roomId;
        $this->associateId = $associateId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('associate.'.$this->roomId),
        ];
    }
}
