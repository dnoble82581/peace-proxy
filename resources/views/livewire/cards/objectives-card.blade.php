<?php

	use App\Models\Negotiation;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Negotiation $negotiation;
		public int $roomId;


		public function mount($negotiationId, $roomId)
		{
			$this->negotiation = $this->getNegotiation($negotiationId);
			$this->roomId = $roomId;
		}

		private function getNegotiation($negotiationId)
		{
			return Negotiation::query()
				->with('objectives')
				->findOrFail($negotiationId);
		}

		public function createObjective():void
		{
			$this->dispatch('modal.open', component: 'modals.create-objective-form',
				arguments: ['negotiationId' => $this->negotiation->id, 'roomId' => $this->roomId]);
		}

		public function editObjective($objectiveId)
		{
			$this->dispatch('modal.open', component: 'modals.edit-objective-form',
				arguments: ['objectiveId' => $objectiveId, 'roomId' => $this->roomId]);
		}

		public function getListeners()
		{
			return [
				"echo-presence:objective.{$this->roomId},ObjectiveCreatedEvent" => 'refresh',
				"echo-presence:objective.{$this->roomId},ObjectiveEditedEvent" => 'refresh',
			];
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
		<div class="px-6 h-40">
			<ol class="list-decimal pl-4 pr-8">
				@foreach($negotiation->objectives->sortBy('priority') as $objective)
					<li class=" flex items-center justify-between">
						<div>
							<span>{{ $objective->objective }}</span>
							<span class="text-sm text-gray-400">({{ $objective->getPriorityString($objective->priority) }})</span>
						</div>
						<button wire:click="editObjective({{ $objective->id }})">
							<x-heroicons::outline.pencil-square class="w-5 h-5 text-blue-500" />
						</button>
					</li>
				@endforeach
			</ol>
		</div>
	@else
		<div class="col-span-2">
			<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Objectives</h3>
		</div>
	@endif
</div>
