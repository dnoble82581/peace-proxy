<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_name');
            // Customer Contact Information
            $table->string('tenant_email'); // Email Address
            $table->string('primary_phone'); // Phone Number
            $table->string('secondary_phone')->nullable(); // Phone Number
            $table->string('tenant_logo')->nullable();

            // Customer Address Fields
            $table->string('address_line1'); // Street Address (Line 1)
            $table->string('address_line2')->nullable(); // Street Address (Line 2)
            $table->string('address_city'); // City
            $table->string('address_state'); // State/Province
            $table->string('address_postal_code'); // Postal/ZIP Code
            $table->string('address_country', 2); // ISO 3166-1 alpha-2 Country Code

            // Tax Information
            $table->string('tax_exempt')->nullable(); // Tax Exemption Status
            $table->string('tax_id')->nullable(); // Customer Tax ID

            // Additional Billing Information
            $table->text('extra_billing_information')->nullable(); // Extra Billing Information

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_id',
                'pm_type',
                'pm_last_four',
                'trial_ends_at',
                'email',
                'phone',
                'tenant_logo',
                'address_line1',
                'address_line2',
                'address_city',
                'address_state',
                'address_postal_code',
                'address_country',
                'tax_exempt',
                'tax_id',
                'extra_billing_information',
            ]);
        });
    }
};
