<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hostage_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hostage_id');
            $table->string('image');
            $table->timestamps();
        });
    }
};
