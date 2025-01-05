<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HostageImage extends Model
{
    protected $guarded = ['id'];

    public function hostage(): BelongsTo
    {
        return $this->belongsTo(Hostage::class);
    }
}
