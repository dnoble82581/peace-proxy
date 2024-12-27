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
            'race' => $this->faker->randomElement([
                'White', 'Mongoloid', 'Negroid', 'Australoid', 'Mixed-Race', 'Other Ethnic Groupings',
            ]),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Transgender', 'Unknown']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zip' => $this->faker->postcode(),
            'date_of_birth' => Carbon::now(),
            'age' => $this->faker->randomNumber(),
            'children' => $this->faker->numberbetween(1, 10),
            'veteran' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'highest_education' => $this->faker->randomElement([
                'Grade School', 'High School', 'College', 'Graduate', 'Unknown',
            ]),
            'substance_abuse' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'mental_health_history' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'physical_description' => $this->faker->text(),
            'notes' => $this->faker->text(),
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
