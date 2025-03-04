<?php

namespace Database\Factories;

use App\Models\Negotiation;
use App\Models\Resolution;
use App\Models\Subject;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ResolutionFactory extends Factory
{
    protected $model = Resolution::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'tenant_id' => Tenant::factory(),
            'negotiation_id' => Negotiation::factory(),
            'subject_id' => Subject::factory(),
        ];
    }
}
