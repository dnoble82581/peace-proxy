<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\BelongsToTenant;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use BelongsToTenant, HasFactory, HasRoles, Notifiable;

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

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('name', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%');
    }

    public function avatarUrl(): string
    {
        if ($this->avatar) {
            return Storage::disk('s3-public')->url($this->avatar);
        }

        return 'https://api.dicebear.com/9.x/initials/svg?seed='.$this->name;
    }

    public function isAdmin(): bool
    {
        return $this->role == 'admin';
    }

    public function isSuperAdmin(): bool
    {
        return $this->role == 'super_admin';
    }

    public function warnings(): HasMany
    {
        return $this->hasMany(Warning::class);
    }

    public function applicationUrl(): string
    {
        if ($this->application()) {
            return url('/documents/user/'.$this->id.'/'.$this->application()->filename);
        }

        return '#';
    }

    public function application()
    {
        return $this->documents()->where('type', 'application')->first();
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function rooms(): BelongsToMany
    {
        return $this->belongsToMany(Room::class)
            ->withPivot('role_id', 'room_id', 'created_at', 'updated_at')
            ->using(RoomUser::class);
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    public function getRoleName()
    {
        $role = $this->getRoleNames()->first();
        str_replace('-', ' ', $role);

        return $role;
    }

    public function responses(): HasMany
    {
        return $this->hasMany(MessageResponse::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function canJoinRoom(int $roomId): bool
    {
        $room = room::findorfail($roomId);
        if ($this->tenant_id == $room->tenant_id) {
            return true;
        }

        return false;
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
