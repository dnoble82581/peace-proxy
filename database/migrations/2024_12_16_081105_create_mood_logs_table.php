<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mood_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->foreignId('room_id');
            $table->foreignId('negotiation_id');
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->dateTime('time');
            $table->integer('mood');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mood_logs');
    }
};
