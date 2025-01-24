<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessmentResponses extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function riskAssessmentQuestions(): BelongsTo
    {
        return $this->belongsTo(RiskAssessmentQuestions::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
