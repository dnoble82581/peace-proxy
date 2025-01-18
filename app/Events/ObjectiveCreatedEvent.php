<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ObjectiveCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public int $objectiveId;

    public function __construct($objectiveId, $roomId)
    {
        $this->roomId = $roomId;
        $this->objectiveId = $objectiveId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('objective.'.$this->roomId),
        ];
    }
}
