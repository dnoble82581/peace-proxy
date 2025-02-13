<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, Conversation $conversation): bool
    {
        return $conversation->participants()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function createMessage(User $user, Conversation $conversation): bool
    {
        // Check if the user is a participant of the conversation
        // Optionally, check for a "banned" status or other conversation-specific restrictions
        //        $isBanned = $conversation->participants()
        //            ->where('user_id', $user->id)
        //            ->value('is_banned'); // Assuming `is_banned` column
        return $conversation->participants()
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user): bool {}

    public function update(User $user, Conversation $conversation): bool {}

    public function delete(User $user, Conversation $conversation): bool {}

    public function restore(User $user, Conversation $conversation): bool {}

    public function forceDelete(User $user, Conversation $conversation): bool {}
}
