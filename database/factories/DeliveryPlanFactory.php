<?php

namespace Database\Factories;

use App\Models\DeliveryPlan;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DeliveryPlanFactory extends Factory
{
    protected $model = DeliveryPlan::class;

    public function definition(): array
    {
        return [
            'delivery_location' => $this->faker->word(),
            'special_instructions' => $this->faker->word(),
            'title' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
