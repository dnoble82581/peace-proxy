<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\CallLog;

class CallLogObserver
{
    public function created(CallLog $callLog): void
    {
        CreateLogEntry::dispatch(
            'Call Log Created',
            get_class($callLog),
            $callLog->id,
            $callLog->toArray(),
            $callLog->negotiation_id,
            $callLog->tenant_id,
            $callLog->user_id
        );
    }

    public function updated(CallLog $callLog): void
    {
        CreateLogEntry::dispatch(
            'Call Log Updated',
            get_class($callLog),
            $callLog->id,
            ['old' => $callLog->getOriginal(), 'new' => $callLog->getChanges()],
            $callLog->negotiation_id,
            $callLog->tenant_id,
            $callLog->user_id
        );
    }

    public function deleted(CallLog $callLog): void
    {
        CreateLogEntry::dispatch(
            'Call Log Deleted',
            get_class($callLog),
            $callLog->id,
            $callLog->toArray(),
            $callLog->negotiation_id,
            $callLog->tenant_id,
            $callLog->user_id
        );
    }
}
