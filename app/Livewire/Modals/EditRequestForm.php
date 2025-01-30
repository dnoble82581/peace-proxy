<?php

namespace App\Livewire\Modals;

use App\Enums\PriorityLevel;
use App\Enums\SubjectRequestStatus;
use App\Enums\SubjectRequestType;
use App\Events\RequestEditedEvent;
use App\Livewire\Forms\SubjectRequestForm;
use App\Models\SubjectRequest;
use WireElements\Pro\Components\Modal\Modal;

class EditRequestForm extends Modal
{
    public SubjectRequest $subjectRequest;

    public SubjectRequestForm $form;

    public array $statuses = [];

    public array $priorities = [];

    public array $types = [];

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
            'size' => '6xl',
        ];
    }

    public function mount($requestId)
    {
        $this->subjectRequest = $this->getRequest($requestId);
        $this->form->fill($this->subjectRequest);
        $this->statuses = SubjectRequestStatus::cases();
        $this->priorities = PriorityLevel::cases();
        $this->types = SubjectRequestType::cases();
    }

    public function getRequest($requestId)
    {
        return SubjectRequest::findOrFail($requestId);
    }

    public function editRequest()
    {
        $this->form->updateSubjectRequest($this->subjectRequest);
        event(new RequestEditedEvent($this->subjectRequest->room_id));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-request-form');
    }
}
