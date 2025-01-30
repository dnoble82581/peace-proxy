<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_requests', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('subject_request'); // Stores the type, details, and urgency
            $table->text('rationale')->nullable(); // Explanation of the request
            $table->text('details')->nullable();
            $table->enum('status',
                [
                    'pending', 'approved', 'rejected', 'cancelled', 'delivered',
                ])->default('pending'); // Status of the request
            $table->enum('type', [
                'Material or Financial', 'Escape or Safe Passage', 'Release of Individuals',
                'Political or Ideological', 'Weapons or Tactical Equipment', 'Negotiation-Driven Requests',
                'Psychological or Emotional Requests', 'Safety Guarantees', 'Miscellaneous',
            ])->default('Material or Financial');
            $table->enum('priority_level', [1, 2, 3]);
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('room_id')->references('id')->on('rooms')->onDelete('cascade');
            $table->foreignId('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->timestamps(); // Created at and updated at
        });
    }
};
