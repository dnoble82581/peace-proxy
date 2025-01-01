<?php

namespace App\Livewire\Modals;

use App\Models\Message;
use App\Models\MessageResponse;
use WireElements\Pro\Components\Modal\Modal;

class MessageResponses extends Modal
{
    public Message $message;

    public MessageResponse $response;

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

    public function mount($messageId)
    {
        $this->message = $this->getMessage($messageId);
    }

    private function getMessage($messageId)
    {
        return Message::findOrFail($messageId);
    }

    public function acknowledge($responseId)
    {
        $this->response = MessageResponse::findOrFail($responseId);
        $this->response->update(['acknowledged' => true]);
    }

    public function render()
    {
        return view('livewire.modals.message-responses');
    }
}
