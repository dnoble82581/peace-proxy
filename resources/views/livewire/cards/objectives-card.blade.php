<?php

	use App\Events\ObjectiveDeletedEvent;
	use App\Events\ObjectiveEditedEvent;
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
				"echo-presence:objective.{$this->roomId},ObjectiveCreatedEvent" => 'refreshObjectives',
				"echo-presence:objective.{$this->roomId},ObjectiveEditedEvent" => 'refreshObjectives',
				"echo-presence:objective.{$this->roomId},ObjectiveDeletedEvent" => 'refresh',
			];
		}

		public function deleteObjective(Objective $objective)
		{
			$objective->delete();
			event(new ObjectiveDeletedEvent($this->roomId));
		}

		public function refreshObjectives()
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
			event(new ObjectiveEditedEvent($objective->id, $this->roomId));
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
				<li class="flex items-center justify-between gap-x-6 px-10 py-2">
					<div class="min-w-0">
						<div class="flex items-start gap-x-3">
							<p class="text-sm/6 font-semibold text-gray-900">{{ $objective->objective }}</p>
							@if($objective->status === 'Complete')
								<p class="mt-0.5 whitespace-nowrap rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
									Complete</p>
								<p class="mt-0.5 whitespace-nowrap rounded-md bg-slate-50 px-1.5 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
									{{ $objective->updated_at->format('M d Y') }}</p>
							@elseif($objective->status === 'In Progress')
								<p class="mt-0.5 whitespace-nowrap rounded-md bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
									In Progress</p>
								@if($objective->priority == 1)
									<p class="mt-0.5 whitespace-nowrap rounded-md bg-red-50 px-1.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
										{{ $objective->getPriorityString($objective->priority) }}</p>
								@elseif($objective->priority == 2)
									<p class="mt-0.5 whitespace-nowrap rounded-md bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
										{{ $objective->getPriorityString($objective->priority) }}</p>
								@elseif($objective->priority == 3)
									<p class="mt-0.5 whitespace-nowrap rounded-md bg-sky-50 px-1.5 py-0.5 text-xs font-medium text-sky-700 ring-1 ring-inset ring-sky-600/20">
										{{ $objective->getPriorityString($objective->priority) }}</p>
								@endif
							@endif

						</div>
						<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
							<p class="whitespace-nowrap">Created on
								<time datetime="2023-03-17T00:00Z">{{ $objective->created_at->format('M d Y') }}</time>
							</p>
							<svg
									viewBox="0 0 2 2"
									class="size-0.5 fill-current">
								<circle
										cx="1"
										cy="1"
										r="1" />
							</svg>
							<p class="truncate">Created by {{ $objective->user->name }}</p>
						</div>
					</div>
					<div class="flex flex-none items-center gap-x-4">
						<button
								wire:click="toggleComplete({{ $objective->id }})"
								class="{{ $objective->status === 'Complete' ? 'text-green-500' : 'text-gray-700' }}">
							<x-heroicons::mini.solid.check />
						</button>
						<button
								wire:click="deleteObjective({{ $objective->id }})"
								class="text-red-400">
							<x-heroicons::outline.trash class="w-5 h-5" />
						</button>
						<button
								wire:click="editObjective({{ $objective->id }})"
								class="text-blue-400">
							<x-heroicons::outline.pencil-square class="w-5 h-5" />
						</button>
					</div>
				</li>
			@endforeach
		</ul>
	@else
		<div class="col-span-2">
			<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Objectives</h3>
		</div>
	@endif
</div>
