<?php

use App\Models\Demand;
use App\Models\Room;
use Livewire\Volt\Component;

new class extends Component {
    public Room $room;
    public Demand $demand;

    public function mount($room)
    {
        $this->room = $room;
    }

    public function addDemand()
    {
        $this->dispatch('modal.open', component: 'modals.create-demand-form');
    }

    public function sendRequest($demandId):void
    {
        $demand = $this->getDemand($demandId);
        $demand->update(['status' => 'Requested']);
        $demand->save();
    }

    private function getDemand($demandId):Demand
    {
        return Demand::findorFail($demandId);
    }
}

?>

{{--ToDo:finish demands--}}
<div
		x-data="{showList: true}"
		class="mt-5">
	<x-board-elements.category-header
			class="bg-teal-400 dark:bg-teal-600"
			value="Demands"
			click-action="addDemand()">
		<x-slot:actions>
			<button
					@click="showList = !showList"
					class="p-1">
				<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
			</button>
			<span
					class="text-sm text-slate-700 dark:text-slate-300"
					x-show="!showList"> {{ $room->subject->demands->count() }} items hidden</span>
		</x-slot:actions>
	</x-board-elements.category-header>
	<ul
			x-show="showList"
			role="list"
			class="divide-y divide-gray-100 px-6 mt-3 dark:divide-gray-700 space-y-4">
		@foreach($room->subject->demands as $demand)
			<x-cards.demand-card
					wirekey="demand-{{$demand->id}}"
					:demand="$demand"
			/>
		@endforeach
	</ul>
</div>
