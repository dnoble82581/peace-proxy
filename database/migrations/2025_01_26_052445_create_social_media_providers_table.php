<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_providers', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name');
            $table->string('website_url');
            $table->string('icon_url')->nullable();
            $table->string('entity_url')->nullable();
            $table->timestamps();
        });
    }
};
