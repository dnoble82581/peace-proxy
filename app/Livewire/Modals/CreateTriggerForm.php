<?php

namespace App\Livewire\Modals;

use App\Events\TriggerCreatedEvent;
use App\Models\Room;
use App\Models\User;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateTriggerForm extends Modal
{
    #[Validate('string|required|min:3|max:255')]
    public string $title;

    #[Validate('string|required|min:3|max:755')]
    public string $description;

    public Room $room;

    public User $user;

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

    public function mount($roomId)
    {
        $this->room = Room::find($roomId);
        $this->user = $this->getUser();
    }

    private function getUser()
    {
        return auth()->user();
    }

    public function saveTrigger()
    {
        $this->validate();
        $newTrigger = $this->room->subject->triggers()->create([
            'title' => $this->title,
            'description' => $this->description,
            'tenant_id' => $this->room->tenant_id,
            'subject_id' => $this->room->subject_id,
        ]);
        event(new TriggerCreatedEvent($newTrigger->id, $this->room->id));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.create-trigger-form');
    }
}
