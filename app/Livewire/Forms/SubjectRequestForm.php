<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use App\Models\SubjectRequest;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectRequestForm extends Form
{
    public ?Room $room;

    #[Validate(['required'])]
    public $subject_request = '';

    #[Validate(['nullable', 'string'])]
    public $rationale = '';

    #[Validate(['nullable', 'string'])]
    public $details = '';

    #[Validate(['required'])]
    public $status = '';

    #[Validate(['required'])]
    public $type;

    #[Validate(['nullable'])]
    public $approval_comments;

    #[Validate(['required'])]
    public $priority_level;

    public function createSubjectRequest($room)
    {
        $this->validate();
        $request = SubjectRequest::create([
            'user_id' => auth()->user()->id,
            'tenant_id' => $room->tenant_id,
            'room_id' => $room->id,
            'subject_request' => [
                'request' => $this->subject_request,
            ],
            'details' => $this->details,
            'rationale' => $this->rationale,
            'status' => $this->status,
            'request_history' => [
                ['timestamp' => now()->todatetimestring(), 'message' => 'Request created by '.auth()->user()->name],
            ],
            'priority_level' => $this->priority_level,
            'approval_comments' => $this->approval_comments,
            'time_requested' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
