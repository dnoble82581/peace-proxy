<?php

namespace App\Models;

use App\Enums\SubjectRequestType;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SubjectRequest extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPriorityString($priorityId): string
    {
        $priorityId = (int) $priorityId;

        return match ($priorityId) {
            1 => 'Low',
            2 => 'Medium',
            3 => 'High',
        };
    }

    public function deliveryPlans(): MorphMany
    {
        return $this->morphMany(DeliveryPlan::class, 'deliverable');
    }

    public function responses(): MorphMany
    {
        return $this->morphMany(Response::class, 'respondable');
    }

    public function badgeColor(): string
    {
        return match ($this->status) {
            'pending' => 'bg-sky-50 text-sky-700 ring-1 ring-sky-600/20 ring-inset',
            'approved' => 'bg-green-50 text-green-700 ring-1 ring-green-600/20 ring-inset',
            'rejected' => 'bg-red-50 text-red-700 ring-1 ring-red-600/20 ring-inset',
            'cancelled' => 'bg-gray-50 text-gray-700 ring-1 ring-gray-600/20 ring-inset',
            'delivered' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20 ring-inset',
            default => 'gray',
        };
    }

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
            'subject_request' => 'array',
            'request_history' => 'array',
            'type' => SubjectRequestType::class,
        ];
    }
}
