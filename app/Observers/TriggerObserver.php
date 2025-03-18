<?php

namespace App\Observers;

use App\Models\NegotiationLog;
use App\Models\Trigger;

class TriggerObserver
{
    public function created(Trigger $trigger): void
    {
        NegotiationLog::create([
            'action' => 'Trigger Created',
            'loggable_type' => Trigger::class,
            'loggable_id' => $trigger->id,
            'data' => [
                'trigger' => $trigger->toArray(),
            ],
        ]);
    }

    public function updated(Trigger $trigger): void
    {
        NegotiationLog::create([
            'action' => 'Trigger Updated',
            'loggable_type' => Trigger::class,
            'loggable_id' => $trigger->id,
            'data' => [
                'old' => $trigger->getOriginal(),
                'new' => $trigger->getChanges(),
            ],
        ]);
    }

    public function deleted(Trigger $trigger): void
    {
        NegotiationLog::create([
            'action' => 'Trigger Deleted',
            'loggable_type' => Trigger::class,
            'loggable_id' => $trigger->id,
            'data' => [
                'trigger' => $trigger->toArray(),
            ],
        ]);
    }
}
