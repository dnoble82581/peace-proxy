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
            $table->foreignId('conversation_id')->nullable()
                ->constrained()
                ->onDelete('cascade'); // If the conversation is deleted, delete the invitation
            $table->foreignId('tenant_id');
            $table->foreignId('room_id');
            $table->foreignId('inviter_id')->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('invitee_id')->constrained()->references('id')->on('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'accepted', 'declined'])->default('pending');
            $table->enum('type', ['public', 'private', 'group'])->default('public');
            $table->string('token')->unique(); // Unique token for invitation links
            $table->string('groupToken')->nullable();
            $table->unique(['inviter_id', 'invitee_id', 'type'], 'inviter_invitee_unique');
            $table->timestamps();
        });
    }
};
