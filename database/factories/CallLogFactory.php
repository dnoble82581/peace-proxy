<?php

namespace Database\Factories;

use App\Models\CallLog;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
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

            'subject_id' => Subject::factory(),
            'negotiation_id' => Negotiation::factory(),
            'tenant_id' => Tenant::factory(),
            'room_id' => Room::factory(),
        ];
    }
}
