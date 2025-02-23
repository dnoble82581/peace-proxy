<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Demand extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function deliveryPlans(): MorphMany
    {
        return $this->morphMany(DeliveryPlan::class, 'deliverable');
    }

    public function responses(): MorphMany
    {
        return $this->morphMany(Response::class, 'respondable');
    }

    public function getBadgeColor(): string
    {
        return match ($this->status) {
            'Approved' => 'bg-green-50 text-green-700 ring-green-600/20',
            'Rejected' => 'bg-red-50 text-red-700 ring-red-600/20',
            'Pending' => 'bg-slate-50 text-slate-700 ring-slate-600/20',
            default => 'bg-gray-50 text-gray-700 ring-gray-600/20',
        };
    }

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }
}
