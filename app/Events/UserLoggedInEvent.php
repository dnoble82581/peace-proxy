<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLoggedInEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $tenantId;

    public function __construct($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('user.'.$this->tenantId),
        ];
    }
}
