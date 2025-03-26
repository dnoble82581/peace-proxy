<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Warrant;

class WarrantObserver
{
    public function created(Warrant $warrant): void
    {
        CreateLogEntry::dispatch(
            'Warrant Created',
            get_class($warrant),
            $warrant->id,
            $warrant->toArray(),
            $warrant->subject->room->negotiation_id,
            $warrant->tenant_id,
            $warrant->user_id
        );
    }

    public function updated(Warrant $warrant): void
    {
        CreateLogEntry::dispatch(
            'Warrant Updated',
            get_class($warrant),
            $warrant->id,
            ['old' => $warrant->getOriginal(), 'new' => $warrant->getChanges()],
            $warrant->subject->room->negotiation_id,
            $warrant->tenant_id,
            $warrant->user_id

        );
    }

    public function deleted(Warrant $warrant): void
    {
        CreateLogEntry::dispatch(
            'Warrant Deleted',
            get_class($warrant),
            $warrant->id,
            $warrant->toArray(),
            $warrant->subject->room->negotiation_id,
            $warrant->tenant_id,
            $warrant->user_id

        );
    }
}
