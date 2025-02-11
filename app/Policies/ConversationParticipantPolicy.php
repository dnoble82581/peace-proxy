<?php

namespace App\Policies;

use App\Models\ConversationParticipant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationParticipantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, ConversationParticipant $conversationParticipant): bool {}

    public function create(User $user): bool {}

    public function update(User $user, ConversationParticipant $conversationParticipant): bool {}

    public function delete(User $user, ConversationParticipant $conversationParticipant): bool {}

    public function restore(User $user, ConversationParticipant $conversationParticipant): bool {}

    public function forceDelete(User $user, ConversationParticipant $conversationParticipant): bool {}
}
