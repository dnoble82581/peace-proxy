<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessmentQuestions extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }
}
