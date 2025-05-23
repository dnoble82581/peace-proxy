<?php

namespace App\Models;

use App\Observers\DemandObserver;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

#[ObservedBy(DemandObserver::class)]
class Demand extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function plans(): MorphToMany
    {
        return $this->morphToMany(
            Plan::class,         // The related model
            'deliverable',       // The polymorphic name ('deliverable_id' + 'deliverable_type')
            'deliverables',      // The pivot table name
            'deliverable_id',    // Foreign key for the parent model in the pivot table
            'plan_id'            // Foreign key for the related model in the pivot table
        );

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

    public function logs(): MorphMany
    {
        return $this->morphMany(NegotiationLog::class, 'loggable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }
}
