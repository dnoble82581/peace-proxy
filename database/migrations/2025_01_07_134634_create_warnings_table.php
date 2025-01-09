<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->foreignId('room_id');
            $table->string('warning_type');
            $table->string('warning');
            $table->timestamps();
        });
    }
};
