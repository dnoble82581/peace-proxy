<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('role_id', 'room_id', 'user_id', 'created_at', 'updated_at')
            ->using(RoomUser::class);
    }

    public function associates(): HasMany
    {
        return $this->hasMany(Associate::class);
    }

    public function subject(): HasOne
    {
        return $this->hasOne(Subject::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(SubjectRequest::class);
    }
}
