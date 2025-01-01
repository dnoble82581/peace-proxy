<?php

namespace App\Livewire\Modals;

use App\Models\Subject;
use Illuminate\View\View;
use WireElements\Pro\Components\Modal\Modal;

class ShowWarrants extends Modal
{
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
            'size' => '4xl',
        ];
    }

    public function mount($subjectId): void
    {
        $this->subject = Subject::find($subjectId);
    }

    public function render(): View
    {
        return view('livewire.modals.show-warrants');
    }

    private function getSubject($subjectId)
    {
        return Subject::query()
            ->with('warrants')
            ->findOrFail($subjectId);
    }
}
