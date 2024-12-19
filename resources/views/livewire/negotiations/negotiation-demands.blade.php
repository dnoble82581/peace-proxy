<?php

use App\Events\DemandDeletedEvent;
use App\Events\DemandUpdatedEvent;
use App\Models\Demand;
use App\Models\Room;
use Illuminate\Auth\Access\AuthorizationException;
use Livewire\Volt\Component;

new class extends Component {
    public Room $room;
    public Demand $demand;

    public function mount($room):void
    {
        $this->room = $room;
    }

    public function addDemand():void
    {
        $this->dispatch('modal.open', component: 'modals.create-demand-form', arguments: ['roomId' => $this->room->id]);
    }

    public function deleteDemand($demandId):void
    {
        $demandToDelete = $this->getDemand($demandId);
        try {
            $demandToDelete->delete();
            event(new DemandDeletedEvent($demandId, $this->room->id));
        } catch (AuthorizationException $exception) {
            Session()->flash('error', 'You ar not authorized to delete this demand.');
        }
    }

    public function updateDemand($demandId)
    {
//	     Set the form and add update functionality
    }

    public function sendRequest($demandId):void
    {
//		ToDO: Add Try Catch and policy
        $demand = $this->getDemand($demandId);
        $demand->update(['status' => 'requested']);
        event(new DemandUpdatedEvent($this->room->id, $demand->id));
    }

    private function getDemand($demandId):Demand
    {
        return Demand::findorFail($demandId);
    }

    public function getListeners():array
    {
        return [
            "echo-presence:demand.{$this->room->id},DemandDeletedEvent" => 'refresh',
            "echo-presence:demand.{$this->room->id},DemandCreatedEvent" => 'refresh',
            "echo-presence:demand.{$this->room->id},DemandUpdatedEvent" => 'refresh',
        ];
    }
}

?>

<div
		x-data="{showList: true}"
		class="">
	<x-board-elements.category-header
			class="bg-teal-400 dark:bg-teal-600"
			value="Demands"
			click-action="addDemand()">
		<x-slot:actions>
			<button
					@click="showList = !showList"
					class="">
				<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
			</button>
			<span
					x-transition:enter="transition ease-out duration-200"
					x-transition:enter-start="opacity-0 scale-95"
					x-transition:enter-end="opacity-100 scale-100"
					x-transition:leave="transition ease-in duration-75"
					x-transition:leave-start="opacity-100 scale-100"
					x-transition:leave-end="opacity-0 scale-95"
					class="text-sm text-slate-700 dark:text-slate-300"
					x-show="!showList"> {{ $room->subject->demands->count() }} items hidden</span>
		</x-slot:actions>
	</x-board-elements.category-header>

	<ul
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="text-sm text-slate-700 dark:text-slate-300"
			x-show="showList"
			role="list"
			class="divide-y divide-gray-100 mt-3 dark:divide-gray-700">

		@if($room->subject->demands->count() == 0)
			<div>No current Demands</div>
		@else
			@foreach($room->subject->demands as $demand)
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
