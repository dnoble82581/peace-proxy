<?php

namespace App\Livewire\Dropdowns;

use App\Models\Room;
use App\Models\User;
use App\Services\Conversations\ParticipantService;
use App\Services\Invitations\InvitationCreationService;
use App\Services\InvitationService;
use Exception;
use Illuminate\View\View;
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

    public function sendPrivateInvitation($inviteeId): void
    {
        $data = [
            'inviter_id' => $this->user->id,
            'invitee_id' => $inviteeId,
            'tenant_id' => $this->room->tenant_id,
            'room_id' => $this->room->id,
        ];

        session()->flash('user_message_'.$inviteeId, 'Waiting for reply');
        $invitationService = new InvitationService;
        $invitationService->sendPrivateInvitation($data);
    }

    /**
     * @throws Throwable
     */
    public function sendGroupInvitation()
    {
        $invitationCreationService = new InvitationCreationService;
        $groupToken = $invitationCreationService->createGroupInvitation($this->user, $this->selectedUsers,
            $this->room);

    }

    /**
     * @throws Exception
     */
    //
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

    public function mount(Room $room): void
    {
        $this->room = $room;
        $this->user = auth()->user();
    }

    public function render(): View
    {
        return view('livewire.dropdowns.sub-menu');
    }

    /**
     * @throws Exception
     */
    public function addUsersToConversation($conversation, $users): void
    {
        $conversationService = new ParticipantService;
        $conversationService->addParticipantsToConversation($conversation, $users);
    }
}
