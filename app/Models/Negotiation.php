<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Negotiation extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function associates(): HasMany
    {
        return $this->hasMany(associate::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function resolution(): HasOne
    {
        return $this->hasOne(Resolution::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'timestamp',
            'end_time' => 'timestamp',
        ];
    }
}
