<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Warrant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class WarrantFactory extends Factory
{
    protected $model = Warrant::class;

    public function definition(): array
    {
        return [
            'offense' => $this->faker->word(),
            'originating_agency' => $this->faker->word(),
            'originating_county' => $this->faker->word(),
            'originating_state' => $this->faker->word(),
            'extraditable' => $this->faker->randomElement(['yes', 'no']),
            'entered_on' => $this->faker->date(),
            'notes' => $this->faker->text(),
            'confirmed' => $this->faker->randomElement(['yes', 'no', 'unknown']),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'subject_id' => Subject::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
