<?php

namespace App\Livewire\Modals;

use App\Events\ResponseUpdatedEvent;
use App\Models\Response;
use App\Models\SubjectRequest;
use WireElements\Pro\Components\Modal\Modal;

class ShowResponseModal extends Modal
{
    public SubjectRequest $subjectRequest;

    public int $acknowledged = 0;

    public int $dismissed = 0;

    public $responses = [];

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

    public function mount($requestId)
    {
        $this->subjectRequest = $this->getRequest($requestId);
        foreach ($this->subjectRequest->responses as $response) {
            $this->responses[$response->id] = [
                'acknowledged' => (int) $response->acknowledged,
                'dismissed' => (int) $response->dismissed,
            ];
        }
    }

    private function getRequest($requestId)
    {
        return SubjectRequest::findOrFail($requestId);
    }

    public function acknowledge($responseId)
    {
        $response = Response::findOrFail($responseId);

        $response->update([
            'acknowledged' => ! $response->acknowledged,
            'dismissed' => false, // Reset dismissed
        ]);

        // Update component state
        $this->responses[$response->id]['acknowledged'] = (int) $response->acknowledged;
        $this->responses[$response->id]['dismissed'] = 0; // Reset dismissed
    }

    //	ToDO: Circle back to this and decide if you need it or not
    public function dismiss($responseId)
    {
        $response = Response::findOrFail($responseId);

        $response->update([
            'dismissed' => ! $response->dismissed,
        ]);

        // Update component state
        //        $this->responses[$response->id]['dismissed'] = (int) $response->dismissed;
        if (count($this->subjectRequest->responses->where('dismissed', false)) == 0) {
            $this->close();
        }
        event(new ResponseUpdatedEvent($this->subjectRequest->room_id));

    }

    public function getListeners(): array
    {
        return [
            "echo-presence:response.{$this->subjectRequest->room_id},ResponseUpdatedEvent" => 'refresh',
        ];
    }

    public function render()
    {
        return view('livewire.modals.show-response-modal');
    }
}
