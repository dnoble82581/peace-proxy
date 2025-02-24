<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliverables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_plan_id');
            $table->unsignedBigInteger('deliverable_id');
            $table->string('deliverable_type');
            $table->timestamps();
        });
    }
};
