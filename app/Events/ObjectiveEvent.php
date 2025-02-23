<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ObjectiveEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public ?int $objectiveId;

    public string $action;

    public function __construct(int $roomId, ?int $objectiveId, string $action)
    {
        $this->roomId = $roomId;
        $this->objectiveId = $objectiveId;
        $this->action = $action;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('objective.'.$this->roomId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'warrantId' => $this->objectiveId,
        ];
    }
}
