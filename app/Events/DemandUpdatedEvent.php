<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandUpdatedEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $demandId;

    public int $roomId;

    public function __construct($roomId, $demandId)
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
