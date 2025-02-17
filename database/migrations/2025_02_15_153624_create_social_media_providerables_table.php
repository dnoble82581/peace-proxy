<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media_providerables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('social_media_provider_id');
            $table->string('providerable_type');
            $table->unsignedBigInteger('providerable_id');
            $table->index(['providerable_type', 'providerable_id'], 'providerable_idx'); // Shorter index name
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_providerables');
    }
};
