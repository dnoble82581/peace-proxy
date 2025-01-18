<?php

namespace Database\Factories;

use App\Models\Call;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CallFactory extends Factory
{
    protected $model = Call::class;

    public function definition(): array
    {
        return [
            'call_recording_url' => $this->faker->url(),
            'start_time' => Carbon::now(),
            'recording_size' => $this->faker->word(),
            'end_time' => Carbon::now(),
            'duration' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'room_id' => Room::factory(),
            'subject_id' => Subject::factory(),
        ];
    }
}
