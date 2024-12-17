<?php

namespace Database\Factories;

use App\Models\Hook;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HookFactory extends Factory
{
    protected $model = Hook::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'subject_id' => 1,
            'tenant_id' => 5,
        ];
    }
}
