<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warrant extends Model
{
    public $guarded = ['id'];

    use BelongsToTenant, HasFactory;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function entered_on(): string
    {
        return Carbon::parse($this->entered_on)->format('M-d-Y');
    }
}
