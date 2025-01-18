<?php

namespace App\Livewire\Modals;

use App\Models\Room;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateWarningForm extends Modal
{
    public Room $room;

    #[Validate('string|required|min:2|max:255')]
    public string $warning;

    #[Validate('required')]
    public string $warning_type;

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

    public function mount($roomId): void
    {
        $this->room = $this->getRoom($roomId);
    }

    private function getRoom($roomId): Room
    {
        return Room::findOrFail($roomId);
    }

    public function createWarning()
    {
        $this->validate();
        $this->room->subject->warnings()->create([
            'warning' => $this->warning,
            'warning_type' => $this->warning_type,
            'tenant_id' => $this->room->tenant_id,
            'subject_id' => $this->room->subject_id,
            'room_id' => $this->room->id,
            'user_id' => auth()->user()->id,
        ]);
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.create-warning-form');
    }
}
