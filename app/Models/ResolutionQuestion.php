<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResolutionQuestion extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'options' => 'array', // Automatically cast JSON to array
    ];

    public function responses(): HasMany
    {
        return $this->hasMany(ResolutionResponse::class);
    }
}
