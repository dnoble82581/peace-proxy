<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question_text');
            $table->string('type')->nullable();
            $table->json('options')->nullable();
            $table->timestamps();
        });
    }
};
