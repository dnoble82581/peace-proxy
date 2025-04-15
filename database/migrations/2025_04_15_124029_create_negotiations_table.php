<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('case_number')->nullable();

            // Location Info
            $table->string('location')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();

            // Timing
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->unsignedInteger('duration_minutes')->nullable();

            // Incident Info
            $table->string('type'); // e.g. Hostage, Barricade, etc.
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('subject_age')->nullable();
            $table->string('subject_gender')->nullable();
            $table->text('subject_motivation')->nullable();
            $table->unsignedInteger('hostage_count')->nullable();
            $table->boolean('weapons_involved')->default(false);
            $table->string('threat_level')->default('Low'); // Consider enum later

            // Team & Strategy
            $table->foreignId('lead_negotiator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('negotiation_strategy')->nullable();
            $table->text('demands_summary')->nullable();
            $table->text('resolution_summary')->nullable();

            // Status
            $table->string('status')->default('Active'); // Active, Resolved, Escalated, etc.
            $table->boolean('is_training')->default(false);

            $table->timestamps();
            $table->softDeletes(); // Optional: for recoverable deletion
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negotiations');
    }
};
