<?php

namespace App\Livewire\Modals;

use App\Events\DemandEvent;
use App\Models\Demand;
use App\Models\Room;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class EditDemandForm extends Modal
{
    #[Validate('string|required|min:3|max:255')]
    public string $title;

    #[Validate('string|required|min:3|max:755')]
    public string $status;

    #[Validate('string|required|min:3|max:755')]
    public string $type;

    #[Validate('string|nullable|min:3')]
    public string $notes;

    #[Validate('required|date|after:today')]
    public string $deadline;

    #[Validate('string|nullable|min:3|max:755')]
    public string $description;

    public Room $room;

    public Demand $demand;

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

    public function mount($roomId, $demandId): void
    {
        $this->demand = $this->getDemand($demandId);
        $this->room = $this->getRoom($roomId);
        $this->setForm();
    }

    private function getDemand($demandId)
    {
        return Demand::findOrFail($demandId);
    }

    private function getRoom($roomId)
    {
        return Room::findOrFail($roomId);
    }

    private function setForm()
    {
        $this->title = $this->demand->title;
        $this->status = $this->demand->status;
        $this->type = $this->demand->type;
        $this->notes = $this->demand->notes;
        $this->deadline = $this->demand->deadline;
        $this->description = $this->demand->description;
    }

    public function updateDemand()
    {
        $this->validate();
        $this->demand->update([
            'title' => $this->title,
            'status' => $this->status,
            'type' => $this->type,
            'notes' => $this->notes,
            'deadline' => $this->deadline,
            'description' => $this->description,
        ]);
        event(new DemandEvent($this->room->id, $this->demand->id, 'edited'));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.edit-demand-form');
    }
}
