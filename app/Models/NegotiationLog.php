<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NegotiationLog extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function loggable(): BelongsTo
    {
        return $this->morphTo();
    }

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
