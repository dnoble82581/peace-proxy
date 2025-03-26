<?php

namespace App\Models;

use App\Observers\WarrantObserver;
use App\Traits\BelongsToTenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(WarrantObserver::class)]
class Warrant extends Model
{
    public $guarded = ['id'];

    use BelongsToTenant, HasFactory;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entered_on(): string
    {
        return Carbon::parse($this->entered_on)->format('M-d-Y');
    }
}
