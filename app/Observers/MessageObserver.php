<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\Message;

class MessageObserver
{
    public function created(Message $message): void
    {
        CreateLogEntry::dispatch(
            'Message Created',
            get_class($message),
            $message->id,
            $message->toArray()
        );
    }

    //    public function updated(Message $message): void
    //    {
    //        CreateLogEntry::dispatch(
    //            'Message Updated',
    //            get_class($message),
    //            $message->id,
    //            ['old' => $message->getOriginal(), 'new' => $message->getChanges()]
    //        );
    //    }

    public function deleted(Message $message): void
    {
        CreateLogEntry::dispatch(
            'Message Deleted',
            get_class($message),
            $message->id,
            $message->toArray()
        );
    }
}
