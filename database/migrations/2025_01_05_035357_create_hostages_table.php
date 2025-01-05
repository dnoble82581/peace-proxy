<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id');
            $table->foreignId('subject_id');
            $table->foreignId('room_id');
            $table->foreignId('tenant_id');
            //            $table->string('image_path')->nullable();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('race')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('dob')->nullable();
            $table->integer('age')->nullable();
            $table->integer('children')->nullable();
            $table->string('veteran')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('x_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('snapchat_url')->nullable();
            $table->text('notes')->nullable();
            $table->text('physical_description')->nullable();
            $table->string('relationship_to_subject')->nullable();
            $table->string('weapons')->nullable();
            $table->string('highest_education')->nullable();
            $table->string('medical_issues')->nullable();
            $table->string('mental_health_history')->nullable();
            $table->string('substance_abuse')->nullable();
            $table->dateTime('last_contacted_at')->nullable();
            $table->timestamps();
        });
    }
};
