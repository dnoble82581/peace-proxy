<?php

namespace App\Livewire\Modals;

use App\Events\ObjectiveEvent;
use App\Models\Negotiation;
use App\Models\Objective;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateObjectiveForm extends Modal
{
    public Negotiation $negotiation;

    public int $roomId;

    #[Validate('string|min:2|max:255')]
    public string $objective = '';

    #[Validate('string')]
    public string $priority = '';

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

    public function createObjective(): void
    {
        $this->validate();
        $newObjective = Objective::create([
            'negotiation_id' => $this->negotiation->id,
            'tenant_id' => $this->negotiation->tenant_id,
            'user_id' => auth()->user()->id,
            'objective' => $this->objective,
            'priority' => $this->priority,
        ]);
        event(new ObjectiveEvent($this->roomId, $newObjective->id, 'created'));

        $this->close();
    }

    public function mount($negotiationId, $roomId): void
    {
        $this->negotiation = $this->getNegotiation($negotiationId);
        $this->roomId = $roomId;
    }

    private function getNegotiation($negotiationId): Negotiation
    {
        return Negotiation::findorFail($negotiationId);
    }

    public function render()
    {
        return view('livewire.modals.create-objective-form');
    }
}
