<?php

namespace App\Livewire\Forms;

use App\Models\Subject;
use App\Models\Warrant;
use Livewire\Attributes\Validate;
use Livewire\Form;

class WarrantForm extends Form
{
    public ?Subject $subject;

    public ?Warrant $warrant;

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

    public function setForm($warrant)
    {
        $this->subject = $warrant->subject;
        $this->offense = $warrant->offense;
        $this->originating_agency = $warrant->originating_agency;
        $this->originating_county = $warrant->originating_county;
        $this->originating_state = $warrant->originating_state;
        $this->extraditable = $warrant->extraditable;
        $this->entered_on = $warrant->entered_on;
        $this->notes = $warrant->notes;
        $this->confirmed = $warrant->confirmed;
    }

    public function update($warrant)
    {
        $this->validate();
        $warrant->update($this->all());
    }

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
