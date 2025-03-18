<?php

namespace App\Jobs;

use App\Models\NegotiationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateLogEntry implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $action;

    public string $loggableType;

    public int $loggableId;

    public array $data;

    /**
     * Create a new job instance.
     */
    public function __construct($action, $loggableType, $loggableId, $data)
    {
        $this->action = $action;
        $this->loggableType = $loggableType;
        $this->loggableId = $loggableId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        NegotiationLog::create([
            'action' => $this->action,
            'loggable_type' => $this->loggableType,
            'loggable_id' => $this->loggableId,
            'data' => $this->data,
        ]);
    }
}
