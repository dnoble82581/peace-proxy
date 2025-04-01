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
            $message->toArray(),
            $message->room->negotiation_id,
            $message->tenant_id,
            $message->senderable_id
        );
    }

    public function deleted(Message $message): void
    {
        CreateLogEntry::dispatch(
            'Message Deleted',
            get_class($message),
            $message->id,
            $message->toArray(),
            $message->room->negotiation_id,
            $message->tenant_id,
            $message->senderable_id

        );
    }
}
