<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\MoodLog;

class MoodObserver
{
    public function created(MoodLog $moodLog): void
    {
        CreateLogEntry::dispatch(
            'Mood Log Created',
            get_class($moodLog),
            $moodLog->id,
            $moodLog->toArray()
        );
    }

    public function updated(MoodLog $moodLog): void
    {
        CreateLogEntry::dispatch(
            'Mood Log Updated',
            get_class($moodLog),
            $moodLog->id,
            ['old' => $moodLog->getOriginal(), 'new' => $moodLog->getChanges()]
        );
        $moodLog->update(['updated_at' => now()]);
    }

    public function deleted(MoodLog $moodLog): void
    {
        CreateLogEntry::dispatch(
            'Mood Log Deleted',
            get_class($moodLog),
            $moodLog->id,
            $moodLog->toArray()
        );
    }
}
