<?php

namespace App\Models;

use App\Services\TenantLogoService;
use App\Traits\ChangePercentageCalculator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class Tenant extends Model
{
    use Billable, ChangePercentageCalculator, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

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

    public function logoUrl(): string
    {
        return (new TenantLogoService)->getLogoUrl($this);
    }

    public function getPhoneAttribute($value): ?string
    {
        return $value ? preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $value) : null;
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function rfis(): HasMany
    {
        return $this->hasMany(RequestForInformation::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function resolutions(): HasMany
    {
        return $this->hasMany(Resolution::class);
    }

    public function resolutionResponses(): HasMany
    {
        return $this->hasMany(ResolutionResponse::class);
    }

    public function resolutionQuestions(): HasMany
    {
        return $this->hasMany(ResolutionQuestion::class);
    }

    public function getRecentUsers(int $duration): int
    {
        return $this->users()->where('created_at', '>=', now()->subDays($duration))->count();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getRecentNegotiations(int $duration): int
    {
        return $this->negotiations()
            ->where('created_at', '>=', now()->subDays($duration))
            ->count();
    }

    public function negotiations(): HasMany
    {
        return $this->hasMany(Negotiation::class);
    }

    public function getUserPercentageChange(): float
    {
        return $this->calculatePercentageChange($this->users());
    }
}
