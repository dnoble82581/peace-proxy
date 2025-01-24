<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('race')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('age')->nullable();
            $table->integer('children')->nullable();
            $table->string('veteran')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('substance_abuse')->nullable();
            $table->string('mental_health_history')->nullable();
            $table->longText('physical_description')->nullable();
            $table->longText('notes')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('x_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('weapons')->nullable();
            $table->boolean('risk_assessment')->default(false);
            $table->text('weapons_details')->nullable();
            $table->foreignId('room_id')->constrained('rooms')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
