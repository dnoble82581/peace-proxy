<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id');
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->boolean('acknowledged')->default(false);
            $table->string('response');
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }
};
