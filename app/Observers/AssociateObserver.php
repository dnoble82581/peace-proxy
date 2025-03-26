<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Associate;

class AssociateObserver
{
    public function created(Associate $associate): void
    {
        CreateLogEntry::dispatch(
            'Associate Created',
            get_class($associate),
            $associate->id,
            $associate->toArray(),
            $associate->negotiation_id,
            $associate->tenant_id,
            $associate->user_id
        );
    }

    public function updated(Associate $associate): void
    {
        CreateLogEntry::dispatch(
            'Associate Updated',
            get_class($associate),
            $associate->id,
            ['old' => $associate->getOriginal(), 'new' => $associate->toArray()],
            $associate->negotiation_id,
            $associate->tenant_id,
            $associate->user_id
        );

    }

    public function deleted(Associate $associate): void
    {
        CreateLogEntry::dispatch(
            'Associate Deleted',
            get_class($associate),
            $associate->id,
            $associate->toArray(),
            $associate->negotiation_id,
            $associate->tenant_id,
            $associate->user_id
        );
    }
}
