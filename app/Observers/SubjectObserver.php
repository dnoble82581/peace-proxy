<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Subject;

class SubjectObserver
{
    public function created(Subject $subject): void
    {
        CreateLogEntry::dispatch(
            'Subject Created',
            get_class($subject),
            $subject->id,
            $subject->toArray(),
            $subject->room->negotiation_id,
            $subject->tenant_id,
            $subject->user_id
        );
    }

    public function updated(Subject $subject): void
    {
        CreateLogEntry::dispatch(
            'Subject Updated',
            get_class($subject),
            $subject->id,
            ['old' => $subject->getOriginal(), 'new' => $subject->getChanges()],
            $subject->room->negotiation_id,
            $subject->tenant_id,
            $subject->user_id

        );
    }

    public function deleted(Subject $subject): void
    {
        CreateLogEntry::dispatch(
            'Subject Deleted',
            get_class($subject),
            $subject->id,
            $subject->toArray(),
            $subject->room->negotiation_id,
            $subject->tenant_id,
            $subject->user_id

        );
    }
}
