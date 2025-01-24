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
            $table->foreignId('risk_assessment_questions_id');
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->foreignId('subject_id');
            $table->string('response');
            $table->timestamps();
        });
    }
};
