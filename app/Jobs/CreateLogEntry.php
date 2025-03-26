<?php

namespace App\Jobs;

use App\Models\NegotiationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class CreateLogEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $action;

    public string $loggableType;

    public int $loggableId;

    public int $negotiationId;

    public int $tenantId;

    public array $data;

    public int $userId;

    /**
     * Create a new job instance.
     */
    public function __construct($action, $loggableType, $loggableId, $data, $negotiationId, $tenantId, $userId)
    {
        $this->action = $action;
        $this->loggableType = $loggableType;
        $this->negotiationId = $negotiationId;
        $this->tenantId = $tenantId;
        $this->loggableId = $loggableId;
        $this->data = $data;
        $this->userId = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('User ID passed to negotiation log:', ['user_id' => $this->userId]);

        NegotiationLog::create([
            'action' => $this->action,
            'loggable_type' => $this->loggableType,
            'negotiation_id' => $this->negotiationId,
            'tenant_id' => $this->tenantId,
            'loggable_id' => $this->loggableId,
            'data' => $this->data,
            'user_id' => $this->userId,
        ]);
    }
}
