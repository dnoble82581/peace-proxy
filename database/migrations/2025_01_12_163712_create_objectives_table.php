<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('objectives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->foreignId('negotiation_id');
            $table->foreignId('user_id');
            $table->integer('priority');
            $table->string('status')->default('In Progress');
            $table->string('objective');
            $table->timestamps();
        });
    }
};
