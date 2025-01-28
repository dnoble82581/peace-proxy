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
            'timestamp' => Carbon::now(),
            'subject_request' => $this->faker->words(),
            'rational' => $this->faker->word(),
            'status' => $this->faker->word(),
            'approval_comments' => $this->faker->word(),
            'priority_level' => $this->faker->randomNumber(),
            'request_history' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'room_id' => Room::factory(),
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
        ];
    }
}
