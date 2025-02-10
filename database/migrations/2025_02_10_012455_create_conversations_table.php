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
            $table->foreignId('sender_id');
            $table->foreignId('receiver_id');
            $table->foreignId('tenant_id');
            $table->timestamps();
        });
    }
};
