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
        'privileges',
        'role',
        'status',
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

    public function warrants(): HasMany
    {
        return $this->hasMany(Warrant::class);
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
        return $this->hasMany(Negotiation::class, 'user_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(Objective::class);
    }

    public function smsMessages(): HasMany
    {
        return $this->hasMany(TextMessage::class, 'sender_id');
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants')
            ->withPivot('joined_at', 'status')
            ->withTimestamps();
    }

    public function sentInvitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'inviter_id');
    }

    public function receivedInvitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'invitee_id');
    }

    public function resolutions(): HasMany
    {
        return $this->hasMany(Resolution::class);
    }

    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'senderable');
    }

    public function associates(): HasMany
    {
        return $this->hasMany(Associate::class);
    }

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    public function callLogs(): HasMany
    {
        return $this->hasMany(CallLog::class);
    }

    public function negotiationLogs(): HasMany
    {
        return $this->hasMany(NegotiationLog::class, 'user_id');
    }

    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class);
    }

    public function hooks(): HasMany
    {
        return $this->hasMany(Hook::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
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
