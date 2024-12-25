<?php

namespace Database\Factories;

use App\Models\CallLog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CallLogFactory extends Factory
{
    protected $model = CallLog::class;

    public function definition(): array
    {
        return [
            'started_at' => $this->faker->dateTimeBetween('2024-12-16', '2024-12-17'),
            'ended_at' => Carbon::now(),
            'duration' => $this->faker->numberBetween(1, 60),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
