<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function hooks(): HasMany
    {
        return $this->hasMany(Hook::class);
    }

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(SubjectRequest::class);
    }
}
