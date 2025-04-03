<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DemandEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public ?int $demandId;

    public string $action;

    public function __construct(int $roomId, ?int $demandId, string $action)
    {
        $this->roomId = $roomId;
        $this->demandId = $demandId;
        $this->action = $action;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('demand.'.$this->roomId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'demandId' => $this->demandId,
        ];
    }
}
