<?php

namespace App\Observers;

use App\Models\Demand;
use App\Models\NegotiationLog;

class DemandObserver
{
    public function created(Demand $demand): void
    {
        NegotiationLog::create([
            'action' => 'Demand Created',
            'loggable_type' => Demand::class,
            'loggable_id' => $demand->id,
            'data' => [
                'demand' => $demand->toArray(),
            ],
        ]);
    }

    public function updated(Demand $demand): void
    {
        NegotiationLog::create([
            'action' => 'Demand Updated',
            'loggable_type' => Demand::class,
            'loggable_id' => $demand->id,
            'data' => [
                'old' => $demand->getOriginal(),
                'new' => $demand->getChanges(),
            ],
        ]);
    }

    public function deleted(Demand $demand): void
    {
        NegotiationLog::create([
            'action' => 'Demand Deleted',
            'loggable_type' => Demand::class,
            'loggable_id' => $demand->id,
            'data' => [
                'demand' => $demand->toArray(),
            ],
        ]);
    }
}
