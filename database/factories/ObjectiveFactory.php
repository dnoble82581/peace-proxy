<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\Objective;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ObjectiveFactory extends Factory
{
    protected $model = Objective::class;

    public function definition(): array
    {
        return [
            'priority' => $this->faker->word(),
            'objective' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Tenant::factory(),
            'negotiation_id' => Negotiation::factory(),
        ];
    }
}
