<?php

namespace Database\Factories;

use App\Models\RiskAssessmentQuestion;
use App\Models\RiskAssessmentResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RiskAssessmentResponseFactory extends Factory
{
    protected $model = RiskAssessmentResponse::class;

    public function definition(): array
    {
        return [
            'response' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'risk_assessment_questions_id' => RiskAssessmentQuestion::factory(),
            'user_id' => User::factory(),
        ];
    }
}
