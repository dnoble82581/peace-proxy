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
        return $this->belongsTo(User::class, 'user_id');
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

    public function logs(): HasMany
    {
        return $this->hasMany(NegotiationLog::class);
    }

    public function rfis()
    {
        return $this->hasMany(RequestForInformation::class, 'negotiation_id');
    }

    public function resolution(): HasOne
    {
        return $this->hasOne(Resolution::class);
    }

    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class);
    }

    public function hooks(): HasMany
    {
        return $this->hasMany(Hook::class);
    }

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
        ];
    }
}
