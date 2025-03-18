<?php

namespace App\Models;

use App\Observers\HookObserver;
use App\Traits\BelongsToTenant;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[ObservedBy(HookObserver::class)]
class Hook extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function broadcastOn(string $event): array
    {
        return [
            new PresenceChannel('hook.'.$this->room_id),
        ];
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(NegotiationLog::class, 'loggable');
    }
}
