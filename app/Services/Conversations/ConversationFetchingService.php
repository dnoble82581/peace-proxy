<?php

namespace App\Services\Conversations;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Conversation_C;

class ConversationFetchingService
{
    public function __construct() {}

    public function fetchUserConversations(User $user)
    {
        return $user->conversations()
            ->where('conversations.tenant_id', $user->tenant_id)
            ->wherePivot('status', 'accepted')
            ->with([
                'invitations',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc'); // Order messages by creation time
                },
            ])->get();
    }

    public function fetchRoomConversations(Room $room): array|Collection|_IH_Conversation_C
    {
        return $room->conversations()
            ->where('conversations.tenant_id', $room->tenant_id)
            ->with([
                'invitations',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc'); // Order messages by creation time
                },
            ])->get();
    }

    public function fetchUserRoomConversations(User $user, Room $room)
    {
        // Fetch conversations for both the user and the room
        return $user->conversations()
            ->where('conversations.room_id', $room->id) // Ensure the conversation is for the given room
            ->where('conversations.tenant_id', $user->tenant_id) // Tenant-specific filtering
            ->wherePivot('status', 'accepted') // Ensure pivot table status
            ->with([
                'invitations',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'asc'); // Order messages by creation time
                },
            ])->get();
    }

    public function fetchDefaultConversation(Room $room)
    {
        return $room->conversations()
            ->where('conversations.room_id', $room->id)
            ->where('type', 'public')
            ->first();
    }
}
