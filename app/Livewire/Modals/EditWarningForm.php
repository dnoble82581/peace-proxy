<?php

namespace App\Livewire\Modals;

use App\Events\WarningUpdatedEvent;
use App\Models\Warning;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class EditWarningForm extends Modal
{
    public Warning $warning;

    #[Validate('string|required|min:2|max:255')]
    public string $warningText;

    #[Validate('required')]
    public string $warning_type;

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

    public function mount($warningId)
    {
        $this->warning = $this->getWarning($warningId);
        $this->setForm();
    }

    private function getWarning($warningId)
    {
        return Warning::findOrFail($warningId);
    }

    private function setForm()
    {
        $this->warningText = $this->warning->warning;
        $this->warning_type = $this->warning->warning_type;
    }

    public function editWarning(): void
    {
        $this->warning->update([
            'warning' => $this->warningText,
            'warning_type' => $this->warning_type,
        ]);
        event(new WarningUpdatedEvent($this->warning->subject->room_id));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-warning-form');
    }
}
