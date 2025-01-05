<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Subject extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

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

    public function hostages(): HasMany
    {
        return $this->hasMany(Hostage::class);
    }

    public function demands(): HasMany
    {
        return $this->hasMany(Demand::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function warrants(): HasMany
    {
        return $this->hasMany(Warrant::class);
    }

    public function phone(): array|string|null
    {
        return preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $this->phone);
    }

    public function getAge()
    {
        $birthDate = explode('-', $this->date_of_birth);

        $birth_date = $this->date_of_birth;
        $current_date = date('Y-m-d');
        $birth_timestamp = strtotime($birth_date);
        $current_timestamp = strtotime($current_date);
        $diff_seconds = $current_timestamp - $birth_timestamp;
        $age_years = $diff_seconds / (60 * 60 * 24 * 365.25);

        return round($age_years);
    }

    public function imageUrl($image): string
    {
        return Storage::disk('s3-public')->url($image);
    }

    public function images(): HasMany
    {
        return $this->hasMany(SubjectImages::class);
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }
}
