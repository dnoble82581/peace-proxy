<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResolutionResponse extends Model
{
    use BelongsToTenant, HasFactory;

    protected $guarded = ['id'];

    public function resolution(): BelongsTo
    {
        return $this->belongsTo(Resolution::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ResolutionQuestion::class, 'resolution_question_id');
    }

    public function getResponseTextAttribute()
    {
        // Use the question's getOptionText() method to resolve the response
        return $this->question ? $this->question->getOptionText($this->response) : null;
    }
}
