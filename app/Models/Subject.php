<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Subject extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function hooks(): HasMany
    {
        return $this->hasMany(Hook::class);
    }

    public function triggers(): HasMany
    {
        return $this->hasMany(Trigger::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function moodLogs(): HasMany
    {
        return $this->hasMany(MoodLog::class);
    }

    public function callLogs(): HasMany
    {
        return $this->hasMany(CallLog::class);
    }

    public function associates(): HasMany
    {
        return $this->hasMany(Associate::class);
    }

    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class);
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function riskAssessment(): HasOne
    {
        return $this->hasOne(RiskAssessmentResponses::class);
    }

    public function warnings(): HasMany
    {
        return $this->hasMany(Warning::class);
    }

    public function warrants(): HasMany
    {
        return $this->hasMany(Warrant::class);
    }

    public function getPhoneAttribute($value): ?string
    {
        return $value ? preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $value) : null;
    }

    public function getAge($date = null): int
    {
        if (! $date) {
            return 0;
        }
        $subjectAge = Carbon::parse($date);

        return $subjectAge->age;
    }

    public function imageUrl($image): string
    {
        return Storage::disk('s3-public')->url($image);
    }

    public function socialMediaProviders(): MorphToMany
    {
        return $this->morphToMany(SocialMediaProvider::class, 'providerable', 'social_media_providerables');
    }

    public function images(): HasMany
    {
        return $this->hasMany(SubjectImages::class);
    }

    public function temporaryImageUrl(): string
    {
        return 'https://api.dicebear.com/9.x/initials/svg?seed='.$this->name;
    }
}
