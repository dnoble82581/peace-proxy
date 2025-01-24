<?php

namespace Database\Factories;

use App\Models\RiskAssessmentQuestions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RiskAssessmentQuestionsFactory extends Factory
{
    protected $model = RiskAssessmentQuestions::class;

    public function definition(): array
    {
        return [
            'question_text' => $this->faker->text(),
            'type' => $this->faker->word(),
            'options' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
