<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('address')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('zip')->nullable();
            $table->string('status')->default('pending');
            $table->string('initial_complainant')->nullable();
            $table->longText('initial_complaint')->nullable();
            $table->string('subject_name')->default('John Doe');
            $table->string('subject_sex')->nullable();
            $table->string('subject_age')->nullable();
            $table->string('subject_phone')->nullable();
            $table->text('subject_motivation')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negotiations');
    }
};
