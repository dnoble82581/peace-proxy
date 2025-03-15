<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->foreignId('room_id');
            $table->unsignedBigInteger('senderable_id');
            $table->string('senderable_type');
            $table->string('recipient')->nullable();
            $table->enum('message_status', ['sent', 'delivered', 'failed'])->default('sent');
            $table->enum('message_type', ['chat', 'text'])->default('chat');
            $table->string('message_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            $table->longText('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Rollback the changes if necessary
            $table->foreignId('user_id');
            $table->foreignId('tenant_id');
            $table->foreignId('room_id');
            $table->dropColumn([
                'senderable_id', 'senderable_type', 'recipient', 'message_status', 'message_type', 'message_id',
                'sent_at',
            ]);
        });

    }
};
