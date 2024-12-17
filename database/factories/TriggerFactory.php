<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\Tenant;
use App\Models\Trigger;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TriggerFactory extends Factory
{
    protected $model = Trigger::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'subject_id' => Subject::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
