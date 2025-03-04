<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_assessment_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_assessment_id')->constrained()->onDelete('cascade'); // link to assessment
            $table->foreignId('risk_assessment_question_id')->constrained()->onDelete('cascade'); // link to question
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('response'); // User's response, e.g., 'Yes', 'No', raw text, or JSON for multiple choices
            $table->timestamps();
        });
    }
};
