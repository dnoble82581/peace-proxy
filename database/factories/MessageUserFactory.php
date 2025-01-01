<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageUserFactory extends Factory
{
    protected $model = MessageResponse::class;

    public function definition(): array
    {
        return [
            'response' => $this->faker->word(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'message_id' => Message::factory(),
            'user_id' => User::factory(),
        ];
    }
}
