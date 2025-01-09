<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    protected function casts(): array
    {
        return [
            'start_time' => 'timestamp',
            'end_time' => 'timestamp',
        ];
    }
}
