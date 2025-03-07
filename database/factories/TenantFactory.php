<?php

namespace Database\Factories;

use App\Models\Tenant;
use Faker\Provider\en_US\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            // Basic Fields
            'tenant_name' => $this->faker->company(), // Company name for the tenant
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            // Customer Contact Fields
            'tenant_email' => $this->faker->unique()->safeEmail(), // Unique email
            'primary_phone' => $this->faker->phoneNumber(), // Random phone number
            'secondary_phone' => $this->faker->phoneNumber(), // Random phone number

            // Customer Address Fields
            'address_line1' => $this->faker->streetAddress(), // Random street address
            'address_line2' => $this->faker->optional()->streetAddress(), // Optional secondary address
            'address_city' => $this->faker->city(), // Random city
            'address_state' => Address::state(), // Random state
            'address_postal_code' => $this->faker->postcode(), // Random postal code
            'address_country' => $this->faker->countryCode(), // ISO 3166-1 alpha-2 country code
            // Additional Billing Information

            // Tax Information
            'tax_exempt' => $this->faker->randomElement(['none', 'exempt', 'reverse']), // Random tax status
            'tax_id' => $this->faker->optional()->regexify('[A-Z0-9]{8,12}'), // Random alphanumeric tax ID

            'extra_billing_information' => $this->faker->optional()->text(200), // Optional additional info

        ];
    }
}
