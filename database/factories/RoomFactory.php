<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'subject_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'negotiation_id' => Negotiation::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
