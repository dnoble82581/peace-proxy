<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\SubjectRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubjectRequestFactory extends Factory
{
    protected $model = SubjectRequest::class;

    public function definition(): array
    {
        return [
            'subject_request' => $this->faker->words(),
            'rationale' => $this->faker->word(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancelled', 'delivered']),
            'priority_level' => $this->faker->randomelement([1, 2, 3]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'room_id' => Room::factory(),
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
        ];
    }
}
