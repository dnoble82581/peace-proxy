<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WarrantEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public ?int $warrantId;

    public string $action;

    public function __construct(int $roomId, ?int $warrantId, string $action)
    {
        $this->roomId = $roomId;
        $this->warrantId = $warrantId;
        $this->action = $action;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('warrant.'.$this->roomId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'warrantId' => $this->warrantId,
        ];
    }
}
