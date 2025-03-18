<?php

namespace App\Observers;

use App\Models\Associate;
use App\Models\NegotiationLog;

class AssociateObserver
{
    public function created(Associate $associate): void
    {
        NegotiationLog::create([
            'action' => 'Associate Created',
            'loggable_type' => Associate::class,
            'loggable_id' => $associate->id,
            'data' => [
                'associate' => $associate->toArray(),
            ],
        ]);
    }

    public function updated(Associate $associate): void
    {
        NegotiationLog::create([
            'action' => 'Associate Updated',
            'loggable_type' => Associate::class,
            'loggable_id' => $associate->id,
            'data' => [
                'old' => $associate->getOriginal(),
                'new' => $associate->getChanges(),
            ],
        ]);
    }

    public function deleted(Associate $associate): void
    {
        NegotiationLog::create([
            'action' => 'Associate Deleted',
            'loggable_type' => Associate::class,
            'loggable_id' => $associate->id,
            'data' => [
                'associate' => $associate->toArray(),
            ],
        ]);
    }
}
