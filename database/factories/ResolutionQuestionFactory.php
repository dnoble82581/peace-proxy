<?php

namespace Database\Factories;

use App\Models\ResolutionQuestion;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ResolutionQuestionFactory extends Factory
{
    protected $model = ResolutionQuestion::class;

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
