<?php

namespace App\Livewire\Dropdowns;

use App\Models\Conversation;
use App\Models\Room;
use App\Models\User;
use App\Services\ConversationService;
use App\Services\InvitationService;
use Livewire\Component;
use Throwable;

class SubMenu extends Component
{
    public array $activeUsers = []; // Array of active users to pass into the dropdown.

    public array $selectedUsers = [];

    public string $buttonLabel = 'New Conversation'; // Label for the button.

    public Room $room;

    public User $user;

    public function getListeners(): array
    {
        return [
            "echo-presence:chat.{$this->room->id},here" => 'handleUserHere',
            "echo-presence:chat.{$this->room->id},joining" => 'handleUserJoining',
        ];
    }

    public function toggleUserSelection(int $userId): void
    {
        // Check if the user is already selected; if so, remove them. Otherwise, add them.
        if (in_array($userId, $this->selectedUsers)) {
            $this->selectedUsers = array_filter($this->selectedUsers, function ($id) use ($userId) {
                return $id !== $userId;
            });
        } else {
            $this->selectedUsers[] = $userId;
        }
    }

    /**
     * @throws Throwable
     */
    public function sendInvitation(string $userIds, string $type): void
    {
        $selectedUsers = explode(',', $userIds);

        $invitationService = new InvitationService;

        // Iterate through each user ID and send an invitation
        foreach ($selectedUsers as $userId) {
            // Skip if there's an existing invitation for this user
            $existingInvite = $invitationService->findExistingInvitation($userId, null);
            if ($existingInvite) {
                continue;
            }

            // Send the invitation (type can be 'private' or 'group')
            $invitationService->sendInvitations(null, [$userId], $this->user->id, $type);

            if ($type === 'group') {
                $newGroupConversation = $this->createGroupChat();
                $this->addUsersToConversation($newGroupConversation, $selectedUsers);
            } else {
                $newPrivateConversation = $this->createPrivateChat($selectedUsers, $this->room->id,
                    $this->user->id);
                $this->addUsersToConversation($newPrivateConversation, $selectedUsers);
            }

            // Flash a session message for feedback
            session()->flash('user_message_'.$userId, "Invitation sent to User ID: $userId");
        }

        // If it's a group invitation, clear selected users
        if ($type === 'group') {
            $this->selectedUsers = [];
        }
    }

    private function createGroupChat(): Conversation
    {
        $conversationService = new ConversationService;

        return $conversationService->createGroupChat([
            'type' => 'group',
            'name' => 'group',
            'initiator_id' => $this->user->id,
            'room_id' => $this->room->id,
            'is_active' => true,
            'tenant_id' => $this->room->tenant_id,
        ]);
    }

    public function addUsersToConversation($conversation, $users): void
    {
        $conversationService = new ConversationService;
        $conversationService->addParticipantsToConversation($conversation, $users);
    }

    /**
     * @throws Throwable
     */
    private function createPrivateChat($userIds, $roomId, $initiatorId): Conversation
    {
        $conversationService = new ConversationService;

        return $conversationService->createPrivateChat($userIds, $roomId, $initiatorId);
    }

    public function handleUserHere($users): void
    {
        $this->activeUsers = collect($users)->filter(function ($user) {
            return $user['id'] !== $this->user->id; // Exclude the current user
        })->map(function ($user) {
            return [
                'id' => $user['id'],
                'name' => $user['name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'],
                'last_active' => now(),
            ];
        })->toArray();
    }

    public function handleUserJoining($user): void
    {
        if ($user['id'] !== $this->user->id) {
            $newUser = [
                'id' => $user['id'],
                'name' => $user['name'],
                'avatar' => $user['avatar'],
                'role' => $user['role'],
                'last_active' => now(),
            ];

            $this->activeUsers[] = $newUser;
            $this->activeUsers = collect($this->activeUsers)->unique('id')->toArray();
        }
    }

    public function mount(Room $room)
    {
        $this->room = $room;
        $this->user = auth()->user();
    }

    public function render()
    {
        return view('livewire.dropdowns.sub-menu');
    }
}
