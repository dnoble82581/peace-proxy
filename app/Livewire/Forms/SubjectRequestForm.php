<?php

namespace App\Livewire\Forms;

use App\Models\Room;
use App\Models\SubjectRequest;
use Livewire\Attributes\Validate;
use Livewire\Form;

class SubjectRequestForm extends Form
{
    public ?Room $room;

    public ?SubjectRequest $subjectRequest;

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
        SubjectRequest::create([
            'user_id' => auth()->user()->id,
            'tenant_id' => $room->tenant_id,
            'room_id' => $room->id,
            'subject_request' => $this->subject_request,
            'type' => $this->type,
            'details' => $this->details,
            'rationale' => $this->rationale,
            'status' => $this->status,
            'priority_level' => $this->priority_level,
            'time_requested' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function updateSubjectRequest($request)
    {
        $this->validate();
        $request->update($this->all());
    }
}
