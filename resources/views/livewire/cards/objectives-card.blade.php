<?php

	use App\Events\ObjectiveDeletedEvent;
	use App\Events\ObjectiveEditedEvent;
	use App\Events\ObjectiveEvent;
	use App\Models\Negotiation;
	use App\Models\Objective;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Negotiation $negotiation;
		public Collection $objectives;
		public int $roomId;


		public function mount($negotiationId, $roomId)
		{
			$this->negotiation = $this->getNegotiation($negotiationId);
			$this->roomId = $roomId;
			$this->objectives = $this->getObjectives();
		}

		private function getNegotiation($negotiationId)
		{
			return Negotiation::query()
				->with('objectives')
				->findOrFail($negotiationId);
		}

		private function getObjectives()
		{
			return $this->negotiation->objectives->sortBy('priority');
		}

		public function createObjective():void
		{
			$this->dispatch('modal.open', component: 'modals.create-objective-form',
				arguments: ['negotiationId' => $this->negotiation->id, 'roomId' => $this->roomId]);
		}

		public function editObjective($objectiveId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-objective-form',
				arguments: ['objectiveId' => $objectiveId, 'roomId' => $this->roomId]);
		}

		public function getListeners():array
		{
			return [
				"echo-presence:objective.{$this->roomId},ObjectiveEvent" => 'refreshObjectives',
			];
		}

		public function deleteObjective(Objective $objective):void
		{
			$objective->delete();
			event(new ObjectiveEvent($this->roomId, null, 'deleted'));
		}

		public function refreshObjectives():void
		{
			$this->objectives = $this->negotiation->objectives->sortBy('priority');
		}

		public function toggleComplete(Objective $objective):void
		{
			if ($objective->status === 'Complete') {
				$objective->update([
					'status' => 'In Progress',
					'updated_at' => now()
				]);

			} else {
				$objective->update([
					'status' => 'Complete',
					'updated_at' => now()
				]);
			}
			event(new ObjectiveEvent($this->roomId, $objective->id, 'edited'));
		}
	}
?>

<div>
	<div class="flex justify-end px-4 mt-2">
		<button wire:click="createObjective">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	@if($negotiation->objectives()->count())
		<ul
				role="list"
				class="divide-y divide-gray-100 space-y-4">
			@foreach($this->objectives as $objective)
				<x-table-elements.objectives-list-item :objective="$objective" />
			@endforeach
		</ul>
	@else
		<div class="col-span-2">
			<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Objectives</h3>
		</div>
	@endif
</div>
