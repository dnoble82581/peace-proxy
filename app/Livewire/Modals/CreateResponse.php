<?php

namespace App\Livewire\Modals;

use App\Events\ResponseEvent;
use App\Models\Demand;
use Livewire\Attributes\Validate;
use WireElements\Pro\Components\Modal\Modal;

class CreateResponse extends Modal
{
    public ?Demand $demand;

    public int $roomId;

    #[Validate('required|string|min:3')]
    public string $responseBody;

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

    public function cancel()
    {
        $this->close();
    }

    public function mount($demandId, $roomId)
    {
        $this->demand = $this->getDemand($demandId);
        $this->roomId = $roomId;
    }

    private function getDemand($demandId): Demand
    {
        return Demand::findOrFail($demandId);
    }

    public function saveResponse()
    {
        $this->validate();
        $newResponse = $this->demand->responses()->create([
            //            'resppondable_id' => auth()->user()->id,
            //			'resppondable_type' => 'App\Models\User',
            'room_id' => $this->roomId,
            'tenant_id' => $this->demand->tenant_id,
            'body' => $this->responseBody,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        event(new ResponseEvent($this->roomId, $newResponse->id, 'created'));
        $this->close();
    }

    public function render()
    {
        return view('livewire.modals.create-response');
    }
}
