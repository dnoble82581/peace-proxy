<?php

namespace App\Livewire\Modals;

use App\Events\HookEvent;
use App\Models\Room;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateHookForm extends Modal
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

    public function mount($roomId): void
    {
        $this->room = Room::find($roomId);
        $this->user = auth()->user();
    }

    public function createHook(): void
    {
        $this->validate();
        $newHook = $this->room->subject->hooks()->create([
            'title' => $this->title,
            'description' => $this->description,
            'tenant_id' => $this->room->tenant_id,
            'subject_id' => $this->room->subject_id,
            'user_id' => $this->user->id,
            'negotiation_id' => $this->room->negotiation_id,
        ]);
        event(new HookEvent($this->room->id, $newHook->id, 'created'));
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.modals.create-hook-form');
    }
}
