<?php

namespace App\Livewire\Modals;

use App\Events\ObjectiveEvent;
use App\Models\Objective;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class EditObjectiveForm extends Modal
{
    public Objective $objectiveToEdit;

    public int $roomId;

    #[Validate('string|min:2|max:255')]
    public string $objective = '';

    #[Validate('integer|min:0|max:3')]
    public int $priority;

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

    /**
     * Define the modal's visual attributes.
     *
     * @return array Key-value pairs of modal attributes.
     */
    public static function attributes(): array
    {
        return [
            // Set the modal size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl, fullscreen
            'size' => '2xl',
        ];
    }

    public function mount($objectiveId, $roomId)
    {
        $this->objectiveToEdit = $this->getObjective($objectiveId);
        $this->roomId = $roomId;
        $this->setForm();
    }

    public function getObjective($objectiveId)
    {
        return Objective::findOrFail($objectiveId);
    }

    public function setForm()
    {
        $this->objective = $this->objectiveToEdit->objective;
        $this->priority = $this->objectiveToEdit->priority;
    }

    public function updateObjective()
    {
        $this->validate();
        $this->objectiveToEdit->update([
            'objective' => $this->objective,
            'priority' => $this->priority,
        ]);
        event(new ObjectiveEvent($this->roomId, $this->objectiveToEdit->id, 'edited'));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-objective-form');
    }
}
