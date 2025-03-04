<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resolution_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->enum('type',
                ['single-choice', 'multiple-choice', 'text', 'date-time'])->default('single-choice');
            $table->json('options')->nullable(); //
            $table->timestamps();
        });
    }
};
