<?php

namespace Database\Factories;

use App\Models\Associate;
use App\Models\Negotiation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AssociateFactory extends Factory
{
    protected $model = Associate::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'race' => $this->faker->randomElement([
                'White', 'Mongoloid', 'Negroid', 'Australoid', 'Mixed-race', 'Other Ethnic Groupings',
            ]),
            'gender' => $this->faker->randomElement(['Male', 'Female', 'Transgender', 'Unknown']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->word(),
            'zipcode' => $this->faker->word(),
            'dob' => $this->faker->dateTimeInInterval(),
            'age' => $this->faker->numberBetween(18, 80),
            'children' => $this->faker->numberBetween(0, 10),
            'veteran' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'facebook_url' => $this->faker->url(),
            'x_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
            'youtube_url' => $this->faker->url(),
            'snapchat_url' => $this->faker->url(),
            'notes' => $this->faker->paragraphs(2, true),
            'physical_description' => $this->faker->paragraph,
            'relationship_to_subject' => $this->faker->randomElement([
                'Parent', 'Sibling', 'Friend', 'Hostage', 'Other',
            ]),
            'weapons' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'highest_education' => $this->faker->randomElement([
                'Grade School', 'High School', 'College', 'Graduate', 'Unknown',
            ]),
            'medical_issues' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'mental_health_history' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'substance_abuse' => $this->faker->randomElement(['Yes', 'No', 'Unknown']),
            'last_contacted_at' => $this->faker->dateTimeBetween('-3 days', '-1 days'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'negotiation_id' => Negotiation::factory(),
            'subject_id' => Subject::factory(),
            'room_id' => Room::factory(),
            'tenant_id' => Tenant::factory(),
        ];
    }
}
