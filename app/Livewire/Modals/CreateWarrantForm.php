<?php

namespace App\Livewire\Modals;

use App\Events\WarrantEvent;
use App\Livewire\Forms\WarrantForm;
use App\Models\Subject;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class CreateWarrantForm extends Modal
{
    public WarrantForm $form;

    public Subject $subject;

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
            'size' => '3xl',
        ];
    }

    public function mount($subjectId): void
    {
        $this->subject = $this->getSubject($subjectId);
    }

    private function getSubject($subjectId): Subject
    {
        return Subject::query()
            ->select('id', 'name', 'tenant_id')
            ->with('warrants')
            ->findOrFail($subjectId);
    }

    public function addWarrant(): void
    {
        $this->form->createWarrant($this->subject);
        event(new WarrantEvent($this->subject->room_id, null, 'created'));
        $this->close();
    }

    public function render(): View
    {
        return view('livewire.modals.create-warrant-form');
    }
}
