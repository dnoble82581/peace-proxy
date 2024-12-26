<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subject_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id');
            $table->string('image');
            $table->timestamps();
        });
    }
};
