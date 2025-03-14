<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NegotiationFactory extends Factory
{
    protected $model = Negotiation::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['Live', 'Practice']),
            'title' => $this->faker->word(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'status' => $this->faker->randomElement(['Active', 'Resolved', 'Canceled']),
            'resolution' => $this->faker->randomElement([
                'Negotiated Surrender', 'Tactical Intervention', 'Combination', 'Suicide', 'Attempted Suicide',
                'Escape', 'LEO Withdrawal', 'Voluntary Surrender', 'Exchange Agreement', 'Safe Passage Agreement',
                'Distraction and Capture', 'Sniper Intervention', 'Breach and Assault',
            ]),
            'initial_complainant' => $this->faker->word(),
            'initial_complaint' => $this->faker->word(),
            'start_time' => Carbon::now(),
            'end_time' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'duration' => null,
            'user_id' => User::factory(),
            'tenant_id' => 1,
        ];
    }
}
