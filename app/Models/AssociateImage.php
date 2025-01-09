<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssociateImage extends Model
{
    protected $guarded = ['id'];

    public function associate(): BelongsTo
    {
        return $this->belongsTo(Associate::class);
    }
}
