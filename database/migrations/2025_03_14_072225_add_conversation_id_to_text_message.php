<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('text_messages', function (Blueprint $table) {
            $table->foreignId('conversation_id')->nullable()->after('id');
            $table->foreignId('room_id')->nullable()->after('conversation_id');
        });
    }
};
