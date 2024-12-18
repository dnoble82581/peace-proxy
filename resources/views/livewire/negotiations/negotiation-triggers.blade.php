<?php

use App\Events\TriggerDeletedEvent;
use App\Models\Room;
use App\Models\Trigger;
use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public Room $room;
    public User $user;
    public Trigger $trigger;


    public function mount($room)
    {
        $this->$room = $room;
        $this->user = $this->getUser();
    }

    private function getUser()
    {
        return auth()->user();
    }

    public function createTrigger()
    {
        $this->dispatch('modal.open', component: 'modals.create-trigger-form', arguments: [
            'roomId' => $this->room->id
        ]);
    }

    public function getListeners()
    {
        return [
            "echo-presence:trigger.{$this->room->id},TriggerCreatedEvent" => 'refresh',
            "echo-presence:trigger.{$this->room->id},TriggerEditedEvent" => 'refresh',
            "echo-presence:trigger.{$this->room->id},TriggerDeletedEvent" => 'refresh',
        ];
    }

    public function deleteTrigger($triggerId)
    {
        $triggerToDelete = Trigger::findOrFail($triggerId);
        $triggerToDelete->delete();
        event(new TriggerDeletedEvent($triggerId, $this->room->id));
    }

    public function editTrigger($triggerId)
    {
        $this->dispatch('modal.open', component: 'modals.edit-trigger-form', arguments: [
            'roomId' => $this->room->id, 'triggerId' => $triggerId
        ]);
    }
}

?>

<div x-data="{showList: true}">
	<x-board-elements.category-header
			class="bg-rose-400 dark:bg-rose-500 dark:text-slate-300 sticky top-0 z-10"
			value="Triggers"
			click-action="createTrigger()">
		<x-slot:actions>
			<button @click="showList = !showList">
				<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
			</button>
			<span
					class="text-sm text-slate-700 dark:text-slate-300"
					x-show="!showList">{{ $room->subject->triggers->count() }} items hidden</span>
		</x-slot:actions>
	</x-board-elements.category-header>

	<div
			x-show="showList"
			class="mt-3 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6">
		@foreach($this->room->subject->triggers as $trigger)
			<div
					x-data="{open:true}"
					class="col-span-3">
				<x-cards.expandable-mid-card class="bg-gray-200">
					<!-- Hook Title -->
					<x-slot:title>
						{{ $trigger->title }}
					</x-slot:title>

					<!-- Hook Description -->
					<x-slot:content>
						{{ $trigger->description }}
					</x-slot:content>

					<!-- Action buttons for editing or deleting the hook -->
					<x-slot:actions>
						<!-- Button to delete the hook -->
						<x-mini-button
								class="mr-2"
								wire:click="deleteTrigger({{ $trigger->id }})"
								rounded
								icon="trash"
								flat
								gray
								interaction="negative"
						/>

						<!-- Button to edit the hook -->
						<x-mini-button
								wire:click="editTrigger({{ $trigger->id }})"
								rounded
								icon="pencil-square"
								flat
								gray
								interaction="neutral"
						/>
					</x-slot:actions>
				</x-cards.expandable-mid-card>
			</div>
		@endforeach
	</div>
</div>
