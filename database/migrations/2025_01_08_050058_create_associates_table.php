<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('negotiation_id');
            $table->foreignId('subject_id');
            $table->foreignId('room_id');
            $table->foreignId('tenant_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('race');
            $table->string('gender');
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('zipcode');
            $table->date('dob');
            $table->integer('age');
            $table->integer('children');
            $table->string('veteran');
            $table->string('facebook_url');
            $table->string('x_url');
            $table->string('instagram_url');
            $table->string('youtube_url');
            $table->string('snapchat_url');
            $table->text('notes');
            $table->text('physical_description');
            $table->string('relationship_to_subject');
            $table->string('weapons');
            $table->string('highest_education');
            $table->text('medical_issues');
            $table->text('mental_health_history');
            $table->string('substance_abuse');
            $table->dateTime('last_contacted_at');
            $table->timestamps();
        });
    }
};
