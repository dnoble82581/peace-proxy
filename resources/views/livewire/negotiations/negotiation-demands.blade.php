<?php

	use App\Events\DemandDeletedEvent;
	use App\Events\DemandUpdatedEvent;
	use App\Models\Demand;
	use App\Models\Room;
	use App\Models\User;
	use App\Traits\Searchable;
	use Illuminate\Auth\Access\AuthorizationException;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		use Searchable;

		public Room $room;
		public Demand $demand;
		public Collection $demands;
		public User $user;

		public function mount($room):void
		{
			$this->room = $room;
			$this->user = auth()->user();
			$this->refreshDemands();
		}

		public function getListeners():array
		{
			return [
				"echo-presence:demand.{$this->room->id},DemandDeletedEvent" => 'refresh',
				"echo-presence:demand.{$this->room->id},DemandCreatedEvent" => 'refresh',
				"echo-presence:demand.{$this->room->id},DemandUpdatedEvent" => 'refresh',
			];
		}

		public function updatedSearch():void
		{
			// Refresh associates dynamically based on the current search query
			$this->refreshDemands();
		}

		public function refreshDemands():void
		{
			$this->demands = $this->applySearch($this->room->subject->demands(), ['title', 'type', 'description']);
		}

		public function addDemand():void
		{
			if ($this->user->can('create', Demand::class)) {
				$this->dispatch('modal.open', component: 'modals.create-demand-form',
					arguments: ['roomId' => $this->room->id]);
			} else {
				dd('denied');
			}

		}

		public function deleteDemand($demandId):void
		{
			$demandToDelete = $this->getDemand($demandId);
			if (auth()->user()->can('delete', $demandToDelete)) {
				try {
					$demandToDelete->delete();
					event(new DemandDeletedEvent($demandId, $this->room->id));
				} catch (AuthorizationException $exception) {
					Session()->flash('error', 'You ar not authorized to delete this demand.');
				}
			}
		}

		public function editDemand($demandId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-demand-form', arguments: [
				'roomId' => $this->room->id, 'demandId' => $demandId
			]);
		}

		public function sendRequest($demandId):void
		{
			$demand = $this->getDemand($demandId);
			if (auth()->user()->can('update', $demand)) {
				try {
					$demand->update(['status' => 'requested']);
					event(new DemandUpdatedEvent($this->room->id, $demand->id));
				} catch (AuthorizationException $exception) {
					Session()->flash('error', 'You are not authorized to edit this demand');
				}
			}
		}

		private function getDemand($demandId):Demand
		{
			return Demand::findorFail($demandId);
		}

	}

?>

<div
		x-data="{showList: true}"
		class="">
	<div class="px-3">
		<x-board-elements.category-header
				class="bg-teal-400 dark:bg-teal-600"
				click-action=""
				label="Demands">

			<x-slot:leftActions>
				<button
						@click="showList = !showList"
						class="">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						class="text-sm text-slate-700 dark:text-slate-300 reusable-transition"
						x-show="!showList"> {{ $room->subject->demands->count() }} items hidden</span>
			</x-slot:leftActions>

			<x-slot:rightActions>
				<x-form-elements.comoponent-search field="search" />
				<button
						wire:click="addDemand()"
						class="flex items-center">
					<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
			</x-slot:rightActions>
		</x-board-elements.category-header>
	</div>

	<ul
			class="text-sm text-slate-700 dark:text-slate-300 reusable-transition divide-y divide-gray-100 mt-3 dark:divide-gray-700"
			x-show="showList"
			role="list">

		@if($room->subject->demands->count() == 0)
			<div class="ml-8 sr-only">No current Demands</div>
		@else
			@foreach($demands as $demand)
				<div class="px-6 mt-4">
					<x-cards.demand-card
							wire:key="demand-card-{{$demand->id}}"
							:demand="$demand"
					/>
				</div>
			@endforeach
		@endif
	</ul>
</div>
