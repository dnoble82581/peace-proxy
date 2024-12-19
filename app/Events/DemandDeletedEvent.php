<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandDeletedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $demandId;

    public int $roomId;

    public function __construct($demandId, $roomId)
    {
        $this->demandId = $demandId;
        $this->roomId = $roomId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('demand.'.$this->roomId),
        ];
    }
}
