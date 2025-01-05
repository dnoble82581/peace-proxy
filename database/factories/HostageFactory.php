<?php

namespace Database\Factories;

use App\Models\Hostage;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HostageFactory extends Factory
{
    protected $model = Hostage::class;

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
            'zipcode' => $this->faker->numberBetween(10000, 99999),
            'dob' => $this->faker->dateTimeBetween('-70 years', '-18 years'),
            'age' => $this->faker->randomNumber(),
            'children' => $this->faker->numberBetween(1, 10),
            'veteran' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'facebook_url' => $this->faker->url(),
            'x_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
            'youtube_url' => $this->faker->url(),
            'snapchat_url' => $this->faker->url(),
            'notes' => $this->faker->paragraph(),
            'physical_description' => $this->faker->paragraph(),
            'relationship_to_subject' => $this->faker->word(),
            'weapons' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'highest_education' => $this->faker->randomElement([
                'Grade School', 'High School', 'College', 'Graduate', 'Unknown',
            ]),
            'medical_issues' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'mental_health_history' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'substance_abuse' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'last_contacted_at' => $this->faker->dateTimeBetween('-1 day', '+1 day'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'negotiation_id' => Negotiation::factory(),
            'subject_id' => Subject::factory(),
            'room_id' => Room::factory(),
        ];
    }
}
