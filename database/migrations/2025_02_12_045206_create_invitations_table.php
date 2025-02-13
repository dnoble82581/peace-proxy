<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->unique(['user_id', 'conversation_id', 'status'], 'unique_user_invitation');
            $table->foreignId('conversation_id')->nullable()
                ->constrained()
                ->onDelete('cascade'); // If the conversation is deleted, delete the invitation
            $table->foreignId('user_id') // Invitee's ID
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('invited_by') // User who sent the invitation
                ->constrained('users')
                ->onDelete('cascade');
            $table->string('invitation_type');
            $table->enum('status', ['pending', 'accepted', 'declined'])
                ->default('pending');

            $table->timestamps();
        });
    }
};
