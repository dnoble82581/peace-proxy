<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubjectRequestEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $roomId;

    public ?int $subjectRequestId;

    public string $action;

    public function __construct(int $roomId, ?int $subjectRequestId, string $action)
    {
        $this->roomId = $roomId;
        $this->subjectRequestId = $subjectRequestId;
        $this->action = $action;
    }

    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('subject-request.'.$this->roomId),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'action' => $this->action,
            'warrantId' => $this->subjectRequestId,
        ];
    }
}
