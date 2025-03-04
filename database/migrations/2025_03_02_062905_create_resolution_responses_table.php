<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resolution_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resolution_id')->constrained()->onDelete('cascade');
            $table->foreignId('resolution_question_id')->constrained()->onDelete('cascade');
            $table->string('response');
            $table->timestamps();
        });
    }
};
