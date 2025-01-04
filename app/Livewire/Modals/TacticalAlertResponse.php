<?php

namespace App\Livewire\Modals;

use App\Livewire\Forms\TacticalAlertResponseForm;
use App\Models\Message;
use App\Models\Room;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class TacticalAlertResponse extends Modal
{
    public Message $message;

    public Room $room;

    public TacticalAlertResponseForm $form;

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

    public function mount($messageId, $roomId): void
    {
        $this->message = $this->getMessage($messageId);
        $this->room = $this->getRoom($roomId);
    }

    private function getMessage($messageId): Message
    {
        return Message::findOrFail($messageId);
    }

    private function getRoom($roomId): Room
    {
        return Room::findOrFail($roomId);
    }

    public function reply(): void
    {
        $this->form->createResponse($this->room, $this->message);
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.modals.tactical-alert-response');
    }
}
