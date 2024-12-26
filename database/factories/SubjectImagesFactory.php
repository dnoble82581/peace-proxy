<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\SubjectImages;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SubjectImagesFactory extends Factory
{
    protected $model = SubjectImages::class;

    public function definition(): array
    {
        return [
            'image' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'subject_id' => Subject::factory(),
        ];
    }
}
