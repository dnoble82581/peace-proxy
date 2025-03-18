<?php

namespace App\Observers;

use App\Models\Hook;
use App\Models\NegotiationLog;

class HookObserver
{
    public function created(Hook $hook): void
    {
        NegotiationLog::create([
            'action' => 'Hook Created',
            'loggable_type' => Hook::class,
            'loggable_id' => $hook->id,
            'data' => [
                'hook' => $hook->toArray(),
            ],
        ]);
    }

    public function updated(Hook $hook): void
    {
        NegotiationLog::create([
            'action' => 'Hook Updated',
            'loggable_type' => Hook::class,
            'loggable_id' => $hook->id,
            'data' => [
                'old' => $hook->getOriginal(),
                'new' => $hook->getChanges(),
            ],
        ]);
    }

    public function deleted(Hook $hook): void
    {
        Negotiationlog::create([
            'action' => 'Hook Deleted',
            'loggable_type' => Hook::class,
            'loggable_id' => $hook->id,
            'data' => [
                'hook' => $hook->toArray(),
            ],
        ]);
    }
}
