<?php

namespace Database\Factories;

use App\Models\RiskAssessmentQuestions;
use App\Models\RiskAssessmentResponses;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RiskAssessmentResponsesFactory extends Factory
{
    protected $model = RiskAssessmentResponses::class;

    public function definition(): array
    {
        return [
            'response' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'risk_assessment_questions_id' => RiskAssessmentQuestions::factory(),
            'user_id' => User::factory(),
        ];
    }
}
