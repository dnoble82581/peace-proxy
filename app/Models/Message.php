<?php

namespace App\Models;

use App\Observers\MessageObserver;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy(MessageObserver::class)]
class Message extends Model
{
    use BelongsToTenant, HasFactory;

    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime',
    ];

    protected $guarded = ['id'];

    public function senderable(): MorphTo
    {
        return $this->morphTo();
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(NegotiationLog::class, 'loggable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }
}
