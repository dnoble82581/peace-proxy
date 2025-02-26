<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_location')->nullable();
            $table->text('special_instructions')->nullable();
            $table->string('title')->default('Primary Delivery Plan');
            $table->text('notes')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('room_id');
            $table->foreignId('tenant_id');
            $table->timestamps();
        });
    }
};
