<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Warning;

class WarningObserver
{
    public function created(Warning $warning): void
    {
        CreateLogEntry::dispatch(
            'Warning Created',
            get_class($warning),
            $warning->id,
            $warning->toArray(),
            $warning->subject->room->negotiation_id,
            $warning->tenant_id,
            $warning->user_id

        );
    }

    public function updated(Warning $warning): void
    {
        CreateLogEntry::dispatch(
            'Warning Updated',
            get_class($warning),
            $warning->id,
            ['old' => $warning->getOriginal(), 'new' => $warning->getChanges()],
            $warning->subject->room->negotiation_id,
            $warning->tenant_id,
            $warning->user_id

        );
    }

    public function deleted(Warning $warning): void
    {
        CreateLogEntry::dispatch(
            'Warning Deleted',
            get_class($warning),
            $warning->id,
            $warning->toArray(),
            $warning->subject->room->negotiation_id,
            $warning->tenant_id,
            $warning->user_id

        );
    }
}
