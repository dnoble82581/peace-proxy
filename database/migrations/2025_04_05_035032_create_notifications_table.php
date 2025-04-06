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
        Schema::create('notifications', function (Blueprint $table) {
            // Unique identifier for each notification
            $table->uuid('id')->primary(); // Laravel uses UUIDs by default for notifications

            // Type of notification (class name)
            $table->string('type'); // Will store "App\Notifications\UserAlert"

            // Polymorphic relationship to the notifiable entity (e.g., User)
            $table->morphs('notifiable'); // Creates notifiable_type (e.g., "App\Models\User") and notifiable_id (e.g., user ID)

            // The notification data stored as JSON
            $table->json('data'); // Stores the array returned by toArray()

            // Timestamp when the notification was read (nullable)
            $table->timestamp('read_at')->nullable();

            // Timestamps for creation and update
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
