<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandCreatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public int $demandId;

    public function __construct($demandId, $roomId)
    {
        $this->roomId = $roomId;
        $this->demandId = $demandId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('demand.'.$this->roomId),
        ];
    }
}
