<?php

	use App\Models\Negotiation;
	use App\Models\Room;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {
		public Room $room;
		public Collection $hostages;
		public Negotiation $negotiation;

		public function mount($room):void
		{
			$this->room = $room;
			$this->hostages = $this->getHostages();
			$this->negotiation = $this->room->negotiation;
		}

		private function getHostages()
		{
			return $this->room->associates->where('relationship_to_subject', 'Hostage');
		}
	}

?>

<div
		x-data="{tab: 'hostages'}"
		class="overflow-y-scroll rounded-lg bg-white shadow col-span-6 dark:bg-gray-800 relative">
	<div class="px-4">
		<x-navigation.card-navigation :labels="['General', 'Test']">
			<x-slot:content>
				<button
						@click="tab = 'hostages'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'hostages' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Hostages</span>
				</button>
				<button
						@click="tab = 'negotiation'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'negotiation' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Negotiation</span>
				</button>
				<button
						@click="tab = 'objectives'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'objectives' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Objectives</span>
				</button>
			</x-slot:content>
		</x-navigation.card-navigation>
	</div>
	<div
			class="overflow-visible"
			x-show="tab === 'hostages'">
		<livewire:cards.hostages-card
				:negotiationId="$negotiation->id"
				:roomId="$this->room->id" />
	</div>
	<div x-show="tab === 'negotiation'">
		<x-cards.negotiations.general-negotiation-card :negotiation="$negotiation" />
	</div>
	<div x-show="tab === 'objectives'">
		<livewire:cards.objectives-card
				:negotiationId="$negotiation->id"
				:roomId="$this->room->id" />
	</div>
</div>
