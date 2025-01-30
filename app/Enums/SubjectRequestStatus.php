<?php

namespace App\Enums;

enum SubjectRequestStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Delivered = 'delivered';

    public function metadata(): array
    {
        return match ($this) {
            self::Pending => ['description' => 'Awaiting approval'],
            self::Approved => ['description' => 'Approved by command'],
            self::Rejected => ['description' => 'Rejected by command'],
            self::Cancelled => ['description' => 'Canceled by command'],
            self::Delivered => ['description' => 'Delivered to Subject'],
        };
    }
}
