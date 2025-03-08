<?php

namespace Database\Factories;

use App\Models\TextMessage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TextMessageFactory extends Factory
{
    protected $model = TextMessage::class;

    public function definition(): array
    {
        return [
            'sender' => $this->faker->word(),
            'recipient' => $this->faker->word(),
            'message_content' => $this->faker->word(),
            'message_status' => $this->faker->word(),
            'message_type' => $this->faker->word(),
            'message_id' => $this->faker->word(),
            'sent_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
