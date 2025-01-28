<?php

namespace App\Livewire\Modals;

use App\Enums\PriorityLevel;
use App\Enums\SubjectRequestStatus;
use App\Enums\SubjectRequestType;
use App\Livewire\Forms\SubjectRequestForm;
use App\Models\Room;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class CreateRequestModal extends Modal
{
    public SubjectRequestForm $form;

    public array $statuses = [];

    public array $priorities = [];

    public array $types = [];

    public Room $room;

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
            'size' => '4xl',
        ];
    }

    public function saveRequest()
    {
        $this->form->createSubjectRequest($this->room);
        $this->close();
    }

    public function mount($roomId)
    {
        $this->room = $this->getRoom($roomId);
        $this->statuses = SubjectRequestStatus::cases();
        $this->priorities = PriorityLevel::cases();
        $this->types = SubjectRequestType::cases();
    }

    private function getRoom($roomId): Room
    {
        return Room::findOrFail($roomId);
    }

    public function render(): View
    {
        return view('livewire.modals.create-request-modal');
    }
}
