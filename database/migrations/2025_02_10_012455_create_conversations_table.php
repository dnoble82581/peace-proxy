<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('public'); // 'individual', 'group'
            $table->string('name')->nullable();
            $table->foreignId('initiator_id'); // The user who initiated this conversation
            $table->foreignId('room_id'); // The room this conversation belongs to.
            $table->foreignId('tenant_id'); // The room this conversation belongs to.
            $table->timestamps();
        });
    }
};
