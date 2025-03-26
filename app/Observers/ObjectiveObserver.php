<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Objective;

class ObjectiveObserver
{
    public function created(Objective $objective): void
    {
        CreateLogEntry::dispatch(
            'Objective Created',
            get_class($objective),
            $objective->id,
            $objective->toArray(),
            $objective->negotiation_id,
            $objective->tenant_id,
            $objective->user_id

        );
    }

    public function updated(Objective $objective): void
    {
        CreateLogEntry::dispatch(
            'Objective Updated',
            get_class($objective),
            $objective->id,
            ['old' => $objective->getOriginal(), 'new' => $objective->toArray()],
            $objective->negotiation_id,
            $objective->tenant_id,
            $objective->user_id

        );
    }

    public function deleted(Objective $objective): void
    {
        CreateLogEntry::dispatch(
            'Objective Deleted',
            get_class($objective),
            $objective->id,
            $objective->toArray(),
            $objective->negotiation_id,
            $objective->tenant_id,
            $objective->user_id

        );
    }
}
