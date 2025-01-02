<?php

namespace App\Livewire\Forms;

use App\Events\NewMessageEvent;
use App\Models\Message;
use App\Models\Room;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TacticalAlertResponseForm extends Form
{
    #[Validate(['required'])]
    public $response = '';

    #[Validate(['nullable'])]
    public $status = '';

    public function createResponse(Room $room, Message $message)
    {
        $this->validate();

        $message->responses()->create([
            'user_id' => auth()->user()->id,
            'response' => $this->response,
            'acknowledged' => false,
            'status' => null,
            'tenant_id' => $room->tenant_id,
        ]);

        broadcast(new NewMessageEvent($message));

    }
}
