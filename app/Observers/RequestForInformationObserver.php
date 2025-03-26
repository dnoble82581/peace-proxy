<?php

namespace App\Observers;

use App\Jobs\CreateLogEntry;
use App\Models\RequestForInformation;

class RequestForInformationObserver
{
    public function created(RequestForInformation $requestForInformation): void
    {
        CreateLogEntry::dispatch(
            'Request For Information Created',
            get_class($requestForInformation),
            $requestForInformation->id,
            $requestForInformation->toArray(),
            $requestForInformation->negotiation_id,
            $requestForInformation->tenant_id,
            $requestForInformation->user_id
        );
    }

    public function updated(RequestForInformation $requestForInformation): void
    {
        CreateLogEntry::dispatch(
            'Request For Information Updated',
            get_class($requestForInformation),
            $requestForInformation->id,
            ['old' => $requestForInformation->getOriginal(), 'new' => $requestForInformation->toArray()],
            $requestForInformation->negotiation_id,
            $requestForInformation->tenant_id,
            $requestForInformation->user_id

        );
    }

    public function deleted(RequestForInformation $requestForInformation): void
    {
        CreateLogEntry::dispatch(
            'Request For Information Deleted',
            get_class($requestForInformation),
            $requestForInformation->id,
            $requestForInformation->toArray(),
            $requestForInformation->negotiation_id,
            $requestForInformation->tenant_id,
            $requestForInformation->user_id

        );
    }
}
