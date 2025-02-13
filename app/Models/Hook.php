<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
