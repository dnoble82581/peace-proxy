<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class NegotiationFactory extends Factory
{
    protected $model = Negotiation::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'status' => $this->faker->word(),
            'initial_complainant' => $this->faker->word(),
            'initial_complaint' => $this->faker->word(),
            'start_time' => Carbon::now(),
            'end_time' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'subject_id' => Subject::factory(),
            'tenant_id' => 1,
        ];
    }
}
