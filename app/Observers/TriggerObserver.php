<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Trigger;

class TriggerObserver
{
    public function created(Trigger $trigger): void
    {
        CreateLogEntry::dispatch(
            'Trigger Created',
            get_class($trigger),
            $trigger->id,
            $trigger->toArray(),
            $trigger->subject->room->negotiation_id,
            $trigger->tenant_id,
            $trigger->user_id
        );
    }

    public function updated(Trigger $trigger): void
    {
        CreateLogEntry::dispatch(
            'Trigger Updated',
            get_class($trigger),
            $trigger->id,
            ['old' => $trigger->getOriginal(), 'new' => $trigger->toArray()],
            $trigger->subject->room->negotiation_id,
            $trigger->tenant_id,
            $trigger->user_id

        );
    }

    public function deleted(Trigger $trigger): void
    {
        CreateLogEntry::dispatch(
            'Trigger Deleted',
            get_class($trigger),
            $trigger->id,
            $trigger->toArray(),
            $trigger->subject->room->negotiation_id,
            $trigger->tenant_id,
            $trigger->user_id

        );
    }
}
