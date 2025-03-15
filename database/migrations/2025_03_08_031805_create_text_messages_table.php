<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('text_messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender'); // Phone number of the sender
            $table->string('recipient'); // Phone number of the recipient
            $table->text('message_content'); // The content of the message
            $table->string('message_status')->default('sent'); // sent, delivered, failed
            $table->enum('message_type', ['sent', 'received']); // sent or received
            $table->string('message_id')->nullable(); // Vonage message ID
            $table->timestamp('sent_at')->nullable(); // Timestamp for when the message was sent
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('senderable_id');
            $table->string('senderable_type');
            $table->unsignedBigInteger('recipient_id');
            $table->timestamps(); // created_at and updated_at
        });
    }
};
