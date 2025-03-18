<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Demand;

class DemandObserver
{
    public function created(Demand $demand): void
    {
        CreateLogEntry::dispatch(
            'Demand Created',
            get_class($demand),
            $demand->id,
            $demand->toArray()
        );
    }

    public function updated(Demand $demand): void
    {
        CreateLogEntry::dispatch(
            'Demand Updated',
            get_class($demand),
            $demand->id,
            ['old' => $demand->getOriginal(), 'new' => $demand->getChanges()]
        );
    }

    public function deleted(Demand $demand): void
    {
        CreateLogEntry::dispatch(
            'Demand Deleted',
            get_class($demand),
            $demand->id,
            $demand->toArray()
        );

    }
}
