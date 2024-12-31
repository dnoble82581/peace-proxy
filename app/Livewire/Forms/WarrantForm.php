<?php

namespace App\Livewire\Forms;

use App\Models\Subject;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WarrantForm extends Form
{
    public ?Subject $subject;

    #[Validate(['required'])]
    public $offense = '';

    #[Validate(['nullable'])]
    public $originating_agency = '';

    #[Validate(['nullable'])]
    public $originating_county = '';

    #[Validate(['nullable'])]
    public $originating_state = '';

    #[Validate(['nullable'])]
    public $extraditable = '';

    #[Validate(['nullable', 'date'])]
    public $entered_on = '';

    #[Validate(['nullable'])]
    public $notes = '';

    #[Validate(['required'])]
    public $confirmed = '';

    public function setForm($warrant) {}

    public function createWarrant($subject): void
    {
        $this->subject = $subject;
        $this->subject->warrants()->create([
            'offense' => $this->offense,
            'originating_agency' => $this->originating_agency,
            'originating_county' => $this->originating_county,
            'originating_state' => $this->originating_state,
            'extraditable' => $this->extraditable,
            'confirmed' => $this->confirmed,
            'entered_on' => $this->entered_on,
            'notes' => $this->notes,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
