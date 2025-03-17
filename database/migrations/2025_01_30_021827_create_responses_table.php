<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->morphs('respondable');
            $table->foreignId('room_id');
            $table->foreignId('tenant_id');
            $table->timestamps();
        });
    }
};
