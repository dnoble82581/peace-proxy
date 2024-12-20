<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'race' => $this->faker->word(),
            'gender' => $this->faker->word(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'date_of_birth' => Carbon::now(),
            'age' => $this->faker->randomNumber(),
            'children' => $this->faker->randomNumber(),
            'veteran' => $this->faker->word(),
            'highest_education' => $this->faker->word(),
            'substance_abuse' => $this->faker->word(),
            'mental_health_history' => $this->faker->word(),
            'physical_description' => $this->faker->text(),
            'notes' => $this->faker->word(),
            'facebook_url' => $this->faker->url(),
            'x_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
            'snapchat_url' => $this->faker->url(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'room_id' => Room::factory(),
            'tenant_id' => 1,
        ];
    }
}
