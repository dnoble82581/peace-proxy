<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id');
            $table->foreignId('negotiation_id');
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hooks');
    }
};
