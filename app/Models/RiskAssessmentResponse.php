<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessmentResponse extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function riskAssessment(): BelongsTo
    {
        return $this->belongsTo(RiskAssessment::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(RiskAssessmentQuestion::class, 'risk_assessment_question_id');
    }
}
