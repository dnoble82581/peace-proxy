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
		x-data="{tab: 'hostages', show: true}"
		class="rounded-lg bg-white shadow dark:bg-gray-800 relative flex-1">
	<div class="px-4">
		<x-navigation.card-navigation
				:labels="['General', 'Test']"
				content-classes="justify-between items-center">
			<x-slot:content>
				<div class="flex space-x-4">
					<button
							@click="tab = 'hostages'"
							class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
							:class="tab === 'hostages' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
						<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
						<span>Hostages ({{ $hostages->count() }})</span>
					</button>
					<button
							@click="tab = 'negotiation'"
							class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
							:class="tab === 'negotiation' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
						<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
						<span>Information</span>
					</button>
					@if(auth()->user()->role === 'Tactical Lead')
						<button
								@click="tab = 'plans'"
								class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
								:class="tab === 'plans' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
							<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
							<span>Plans</span>
						</button>
					@endif
				</div>
				<div>
					<button
							@click="show = !show"
							class="focus:outline-none">
						<x-heroicons::micro.solid.chevron-up-down class="w-5 dark-light-text" />
					</button>
				</div>
			</x-slot:content>
		</x-navigation.card-navigation>
	</div>
	<div
			x-show="show"
			class="h-48 p-2 overflow-y-auto reusable-transition">
		<div
				class=""
				x-show="tab === 'hostages'">
			<livewire:cards.hostages-card
					:negotiationId="$negotiation->id"
					:roomId="$this->room->id" />
		</div>
		<div x-show="tab === 'negotiation'">
			<x-cards.negotiations.general-negotiation-card :negotiation="$negotiation" />
		</div>
		@if(auth()->user()->role === 'Tactical Lead')
			<div x-show="tab === 'plans'">
				<livewire:cards.plans-card :roomId="$this->room->id" />
			</div>
		@endif
	</div>
</div>
