<?php

namespace Database\Factories;

use App\Models\MoodLog;
use App\Models\Negotiation;
use App\Models\Subject;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MoodLogFactory extends Factory
{
    protected $model = MoodLog::class;

    public function definition(): array
    {
        return [
            'time' => \Carbon\Carbon::instance(fake()->dateTimeBetween('-1 months', '+1 months')),
            'mood' => $this->faker->numberBetween(-4, 4),
            'name' => $this->faker->randomElement([
                'Saddest', 'Sad', 'Down', 'Anxious', 'Base', 'Happy', 'Nervous', 'Upset', 'Mad',
            ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'subject_id' => Subject::factory(),
            'room_id' => 3,
            'negotiation_id' => Negotiation::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
