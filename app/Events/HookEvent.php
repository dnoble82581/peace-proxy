<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HookEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public ?int $hookId;

    public string $action;

    public function __construct(int $roomId, ?int $hookId, string $action)
    {
        $this->roomId = $roomId;
        $this->hookId = $hookId;
        $this->action = $action;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('hook.'.$this->roomId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'associateId' => $this->hookId,
        ];
    }
}
