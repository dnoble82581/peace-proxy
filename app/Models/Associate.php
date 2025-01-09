<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Associate extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function negotiation(): BelongsTo
    {
        return $this->belongsTo(Negotiation::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(AssociateImage::class);
    }

    public function imageUrl($image): string
    {
        return Storage::disk('s3-public')->url($image);
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

    public function temporaryImageUrl(): string
    {
        return 'https://api.dicebear.com/9.x/initials/svg?seed='.$this->name;
    }

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'last_contacted_at' => 'datetime',
        ];
    }
}
