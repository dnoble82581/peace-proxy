<?php

namespace App\Livewire\Modals;

use App\Events\RequestForInformationEvent;
use App\Models\RequestForInformation;
use WireElements\Pro\Components\Modal\Modal;

class EditRfiModal extends Modal
{
    public RequestForInformation $rfi;

    public string $request;

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

    public function mount($rfiId)
    {
        $this->rfi = $this->getRfi($rfiId);
        $this->request = $this->rfi->request;
    }

    private function getRfi($rfiId): RequestForInformation
    {
        return RequestForInformation::findOrFail($rfiId);
    }

    public function updateRfi(): void
    {
        $this->rfi->update([
            'request' => $this->request,
        ]);
        event(new RequestForInformationEvent($this->rfi->room_id, $this->rfi->id, 'edited'));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-rfi-modal');
    }
}
