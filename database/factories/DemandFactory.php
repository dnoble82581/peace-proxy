<?php

namespace Database\Factories;

use App\Models\Demand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DemandFactory extends Factory
{
    protected $model = Demand::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomelement(['Substantive', 'Expressive', 'Secondary']),
            'deadline' => Carbon::now(),
            'description' => $this->faker->text(),
            'title' => $this->faker->word(),
            'status' => $this->faker->randomelement(['Closed', 'Pending', 'Approved', 'Rejected']),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'subject_id' => 1,
            'tenant_id' => 5,
        ];
    }
}
