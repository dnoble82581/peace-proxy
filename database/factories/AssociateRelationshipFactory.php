<?php

namespace Database\Factories;

use App\Models\AssociateRelationship;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AssociateRelationshipFactory extends Factory
{
    protected $model = AssociateRelationship::class;

    public function definition(): array
    {
        return [
            'relationship' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
