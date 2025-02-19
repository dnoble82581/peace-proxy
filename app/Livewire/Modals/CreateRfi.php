<?php

namespace App\Livewire\Modals;

use App\Models\Room;
use App\Models\Subject;
use App\Models\User;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateRfi extends Modal
{
    public Subject $subject;

    public User $user;

    public Room $room;

    #[Validate('required|string|max:255')]
    public string $rfi;

    public static function behavior(): array
    {
        return [
            // Close the modal if the escape key is pressed
            'close-on-escape' => true,
            // Close the modal if someone clicks outside the modal
            'close-on-backdrop-click' => true,
            // Trap the users focus inside the modal (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the modal
            'remove-state-on-close' => false,
        ];
    }

    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, fullscreen
            'size' => '2xl',
        ];
    }

    public function mount($userId, $subjectId, $roomId): void
    {
        $this->subject = $this->getSubject($subjectId);
        $this->user = $this->getUser($userId);
        $this->room = $this->getRoom($roomId);
    }

    private function getSubject(int $subjectId): Subject
    {
        return Subject::findOrFail($subjectId);
    }

    private function getUser(int $UserId): User
    {
        return User::findOrFail($UserId);
    }

    private function getRoom(int $roomId): Room
    {
        return Room::findOrFail($roomId);
    }

    public function render()
    {
        return view('livewire.modals.create-rfi');
    }

    public function submit()
    {
        $this->validate();
        $this->subject->rfis()->create([
            'request' => $this->rfi,
            'tenant_id' => $this->room->tenant_id,
            'room_id' => $this->room->id,
            'user_id' => $this->user->id,
        ]);
        $this->close();
    }
}
