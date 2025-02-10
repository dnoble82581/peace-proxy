<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Services\UserAvatarService;
use App\Traits\BelongsToTenant;
use App\Traits\UserPrivilegeTrait;
use App\Traits\UserScopesTrait;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use BelongsToTenant, HasFactory, Notifiable, UserPrivilegeTrait, UserScopesTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'primary_phone',
        'secondary_phone',
        'avatar',
        'role',
        'status',
        'title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function avatarUrl(): string
    {
        return (new UserAvatarService)->getAvatarUrl($this);
    }

    public function isAdmin(): bool
    {
        return $this->privileges == 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role == 'super_admin';
    }

    public function warnings(): HasMany
    {
        return $this->hasMany(Warning::class);
    }

    public function application()
    {
        return $this->documents()->where('type', 'application')->first();
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'sender_id')->orWhere('receiver_id', $this->id);
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function requests(): HasMany
    {
        return $this->hasMany(SubjectRequest::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(MessageResponse::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
