<?php

namespace App\Livewire\Modals;

use App\Events\ResponseCreatedEvent;
use App\Models\Room;
use App\Models\SubjectRequest;
use WireElements\Pro\Components\Modal\Modal;

class CreateResponseForm extends Modal
{
    public Room $room;

    public string $response;

    public SubjectRequest $subjectRequest;

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

    public function mount($roomId, $requestId)
    {
        $this->room = $this->getRoom($roomId);
        $this->subjectRequest = $this->getRequest($requestId);
    }

    private function getRoom($roomId)
    {
        return Room::findOrFail($roomId);
    }

    private function getRequest($requestId)
    {
        return SubjectRequest::findOrFail($requestId);
    }

    public function saveResponse()
    {
        $this->validate(['response' => 'required|string|max:255']);
        $this->subjectRequest->responses()->create([
            'body' => $this->response,
            'room_id' => $this->room->id,
            'subject_id' => $this->room->subject_id,
            'user_id' => auth()->user()->id,
            'tenant_id' => $this->room->tenant_id,
        ]);
        event(new ResponseCreatedEvent($this->room->id));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.create-response-form');
    }
}
