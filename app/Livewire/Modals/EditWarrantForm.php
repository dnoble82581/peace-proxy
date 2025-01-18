<?php

namespace App\Livewire\Modals;

use App\Events\WarrantEditedEvent;
use App\Livewire\Forms\WarrantForm;
use App\Models\Warrant;
use WireElements\Pro\Components\Modal\Modal;

class EditWarrantForm extends Modal
{
    public Warrant $warrant;

    public WarrantForm $form;

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

    public function mount($warrantId)
    {
        $this->warrant = $this->getWarrant($warrantId);
        $this->form->setForm($this->warrant);
    }

    private function getWarrant($warrantId)
    {
        return Warrant::findOrFail($warrantId);
    }

    public function editWarrant()
    {
        $this->form->update($this->warrant);
        event(new WarrantEditedEvent($this->warrant->subject->room_id));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-warrant-form');
    }
}
