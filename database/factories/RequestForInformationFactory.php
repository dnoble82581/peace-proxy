<?php

namespace Database\Factories;

use App\Models\RequestForInformation;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RequestForInformationFactory extends Factory
{
    protected $model = RequestForInformation::class;

    public function definition(): array
    {
        return [
            'request' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'tenant_id' => Tenant::factory(),
            'room_id' => Room::factory(),
            'subject_id' => Subject::factory(),
        ];
    }
}
