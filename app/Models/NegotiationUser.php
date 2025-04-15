<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class NegotiationUser extends Pivot
{
    protected $table = 'negotiation_user';

    protected $fillable = [
        'negotiation_id',
        'user_id',
        'role',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];
}
