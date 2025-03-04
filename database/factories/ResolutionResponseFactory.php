<?php

namespace Database\Factories;

use App\Models\Resolution;
use App\Models\ResolutionQuestion;
use App\Models\ResolutionResponse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ResolutionResponseFactory extends Factory
{
    protected $model = ResolutionResponse::class;

    public function definition(): array
    {
        return [
            'response' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'resolution_id' => Resolution::factory(),
            'resolution_question_id' => ResolutionQuestion::factory(),
        ];
    }
}
