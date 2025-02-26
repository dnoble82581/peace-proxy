<?php

namespace App\Livewire\Modals;

use App\Events\DeliveryPlanEvent;
use App\Events\DemandEvent;
use App\Models\Document;
use App\Models\Plan;
use App\Models\Room;
use App\Services\DocumentProcessor;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use WireElements\Pro\Components\Modal\Modal;

class CreateDeliveryPlan extends Modal
{
    public Room $room;

    public ?Plan $plan = null;

    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $delivery_location;

    #[Validate('string')]
    public string $special_instructions;

    #[Validate('required|string|max:255')]
    public string $title;

    #[Validate('string')]
    public string $notes;

    #[Validate(['documents' => 'nullable|array', 'documents.*' => 'file|mimes:pdf|max:10240'])]
    public $documents = [];

    public $old_documents = [];

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

    /**
     * @throws Exception
     */
    public function saveDeliveryPlan(): void
    {
        $this->validate();
        if ($this->plan) {
            // Update existing delivery plan
            $this->plan->update([
                'delivery_location' => $this->delivery_location,
                'special_instructions' => $this->special_instructions,
                'title' => $this->title,
                'notes' => $this->notes,
                'updated_at' => now(),
            ]);

            if ($this->documents) {
                $this->handleDocuments($this->plan);
            }
            event(new DeliveryPlanEvent($this->room->id, $this->plan->id, 'updated'));
            event(new DemandEvent($this->room->id, null, 'edited'));

        } else {
            // Create new delivery plan
            $newPlan = $this->room->plans()->create([
                'delivery_location' => $this->delivery_location,
                'special_instructions' => $this->special_instructions,
                'title' => $this->title,
                'notes' => $this->notes,
                'tenant_id' => $this->room->tenant_id,
                'user_id' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($this->documents) {
                $this->handleDocuments($newPlan);
            }
            event(new DeliveryPlanEvent($this->room->id, null, 'created'));
            event(new DemandEvent($this->room->id, null, 'edited'));

        }
        $this->close();
    }

    /**
     * @throws Exception
     */
    private function handleDocuments($newDeliveryPlan): void
    {
        $documentProcessor = new DocumentProcessor;
        $documentProcessor->processDocuments($this->documents, $newDeliveryPlan, auth()->user()->id);
    }

    public function mount($roomId, $planId = null): void
    {

        $this->room = $this->getRoom($roomId);

        if ($planId) {
            $this->plan = $this->room->plans()->findOrFail($planId);

            $this->delivery_location = $this->plan->delivery_location;
            $this->special_instructions = $this->plan->special_instructions;
            $this->title = $this->plan->title;
            $this->notes = $this->plan->notes;

            if ($this->plan->documents->count()) {
                foreach ($this->plan->documents as $document) {
                    $this->old_documents[] = $document;
                }
            }
        }
    }

    private function getRoom($roomId): Room
    {
        return Room::findOrFail($roomId);
    }

    /**
     * @throws Exception
     */
    public function deleteDocument($documentId): void
    {
        $document = Document::findOrFail($documentId);
        $documentProcessor = new DocumentProcessor;
        $documentProcessor->deleteDocument($this->plan, $document->filename);

    }

    public function render()
    {
        return view('livewire.modals.create-delivery-plan');
    }
}
