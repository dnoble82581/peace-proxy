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
            $table->enum('type', ['private', 'public', 'group'])->default('private'); // 'individual', 'group'
            $table->string('name')->nullable();
            $table->foreignId('tenant_id'); // The room this conversation belongs to.
            $table->foreignId('room_id');
            $table->string('token')->unique()->nullable();
            $table->timestamps();
        });
    }
};
