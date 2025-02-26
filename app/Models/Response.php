<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Response extends Model
{
    use BelongsToTenant;

    protected $guarded = ['id'];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
