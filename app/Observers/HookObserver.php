<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Hook;

class HookObserver
{
    public function created(Hook $hook): void
    {
        CreateLogEntry::dispatch(
            'Hook Created',
            get_class($hook),
            $hook->id,
            $hook->toArray()
        );
    }

    public function updated(Hook $hook): void
    {
        CreateLogEntry::dispatch(
            'Hook Updated',
            get_class($hook),
            $hook->id,
            ['old' => $hook->getOriginal(), 'new' => $hook->getChanges()]
        );
    }

    public function deleted(Hook $hook): void
    {
        CreateLogEntry::dispatch(
            'Hook Deleted',
            get_class($hook),
            $hook->id,
            $hook->toArray()
        );
    }
}
