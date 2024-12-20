<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warrants', function (Blueprint $table) {
            $table->id();
            $table->string('offense');
            $table->string('originating_agency')->nullable();
            $table->string('originating_county')->nullable();
            $table->string('originating_state')->nullable();
            $table->string('extraditable')->nullable();
            $table->date('entered_on')->nullable();
            $table->text('notes')->nullable();
            $table->string('confirmed')->default('no');
            $table->foreignId('subject_id');
            $table->foreignId('tenant_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warrants');
    }
};
