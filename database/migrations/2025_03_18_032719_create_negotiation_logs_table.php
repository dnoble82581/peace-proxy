<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negotiation_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->morphs('loggable');
            $table->foreignId('negotiation_id')->constrained()->cascadeOnDelete(); // Scoping to negotiation
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete(); // Scoping to tenant
            $table->json('data')->nullable();
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negotiation_logs');
    }
};
