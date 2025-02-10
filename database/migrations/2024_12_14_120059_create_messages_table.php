<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->foreignId('room_id');
            $table->foreignId('conversation_id')->nullable()->default(null);
            $table->boolean('emergency')->default(false);
            $table->boolean('important')->default(false);
            $table->boolean('to_primary')->default(false);
            $table->boolean('to_tactical')->default(false);
            $table->longText('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
