<?php

namespace Database\Factories;

use App\Models\RiskAssessmentQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RiskAssessmentQuestionFactory extends Factory
{
    protected $model = RiskAssessmentQuestion::class;

    public function definition(): array
    {
        return [
            'question_text' => $this->faker->text(),
            'type' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
