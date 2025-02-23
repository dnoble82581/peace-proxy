<?php

	use App\Events\TriggerDeletedEvent;
	use App\Events\TriggerEvent;
	use App\Models\Room;
	use App\Models\Trigger;
	use App\Models\User;
	use App\Traits\Searchable;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		use Searchable;

		public Room $room;
		public User $user;
		public Trigger $trigger;
		public Collection $triggers;


		public function mount($room):void
		{
			$this->room = $room;
			$this->user = $this->getUser();
			$this->refreshTriggers();
		}

		public function updatedSearch():void
		{
			// Refresh associates dynamically based on the current search query
			$this->refreshTriggers();
		}

		public function refreshTriggers():void
		{
			$this->triggers = $this->applySearch($this->room->subject->triggers(), ['title']);
		}

		private function getUser():User
		{
			return auth()->user();
		}

		public function createTrigger():void
		{
			$this->dispatch('modal.open', component: 'modals.create-trigger-form', arguments: [
				'roomId' => $this->room->id
			]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:trigger.{$this->room->id},TriggerEvent" => 'refreshTriggers',
//				"echo-presence:trigger.{$this->room->id},TriggerEditedEvent" => 'refreshTriggers',
//				"echo-presence:trigger.{$this->room->id},TriggerDeletedEvent" => 'refreshTriggers',
			];
		}

		public function deleteTrigger($triggerId):void
		{
			$triggerToDelete = Trigger::findOrFail($triggerId);
			$triggerToDelete->delete();
			event(new TriggerEvent($this->room->id, null, 'deleted'));
		}

		public function editTrigger($triggerId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-trigger-form', arguments: [
				'roomId' => $this->room->id, 'triggerId' => $triggerId
			]);
		}
	}

?>

<div x-data="{showList: true}">
	<div class="px-3">
		<x-board-elements.category-header
				class="bg-rose-400 dark:bg-rose-500 dark:text-slate-300"
				label="Triggers">
			<x-slot:leftActions>
				<button @click="showList = !showList">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						class="text-sm text-slate-700 dark:text-slate-300 reuse-transition"
						x-show="!showList">{{ $room->subject->triggers->count() }} items hidden</span>
			</x-slot:leftActions>

			<x-slot:rightActions>
				<x-form-elements.comoponent-search field="search" />
				<button
						wire:click="createTrigger()"
						class="flex items-center">
					<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
			</x-slot:rightActions>

		</x-board-elements.category-header>
	</div>

	<div

			x-show="showList"
			class="mt-3 sm:grid sm:grid-cols-6 sm:gap-4 sm:px-6 reuse-transition">
		@foreach($this->triggers as $trigger)
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
								gray
								flat
								rounded
								icon="trash"
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
