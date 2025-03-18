<?php

namespace Database\Factories;

use App\Models\NegotiationLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NegotiationLogFactory extends Factory
{
    protected $model = NegotiationLog::class;

    public function definition(): array
    {
        return [
            'action' => $this->faker->word(),
            'data' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
