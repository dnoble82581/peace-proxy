<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Hook;
use Illuminate\Support\Facades\Log;

class HookObserver
{
    public function created(Hook $hook): void
    {
        Log::info($hook->user_id);
        CreateLogEntry::dispatch(
            'Hook Created',
            get_class($hook),
            $hook->id,
            $hook->toArray(),
            $hook->subject->room->negotiation_id,
            $hook->tenant_id,
            $hook->user_id
        );

    }

    public function updated(Hook $hook): void
    {
        CreateLogEntry::dispatch(
            'Hook Updated',
            get_class($hook),
            $hook->id,
            ['old' => $hook->getOriginal(), 'new' => $hook->toArray()],
            $hook->subject->room->negotiation_id,
            $hook->tenant_id,
            $hook->user_id
        );
    }

    public function deleted(Hook $hook): void
    {
        CreateLogEntry::dispatch(
            'Hook Deleted',
            get_class($hook),
            $hook->id,
            $hook->toArray(),
            $hook->subject->room->negotiation_id,
            $hook->tenant_id,
            $hook->user_id
        );
    }
}
