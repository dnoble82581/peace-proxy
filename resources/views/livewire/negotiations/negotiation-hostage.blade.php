<?php

	use App\Models\Room;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {
		public Room $room;
		public Collection $hostages;


		public function mount($room)
		{
			$this->room = $room;
			$this->hostages = $this->getHostages();
		}

		private function getHostages()
		{
			return $this->room->hostages;
		}

		public function editHostage($hostage)
		{
			return redirect(route('edit.hostage',
				[
					'roomId' => $this->room->id,
					'hostage' => $hostage
				]
			));
		}

	}

?>

<div x-data="{showList:true}">
	<div>
		<x-board-elements.category-header
				class="bg-violet-400 dark:bg-violet-600 border-gray-300"
				value="Hostages">
			<x-slot:actions>
				<button @click="showList = !showList">
					<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
				</button>
				<span
						x-transition:enter="transition ease-out duration-200"
						x-transition:enter-start="opacity-0 scale-95"
						x-transition:enter-end="opacity-100 scale-100"
						x-transition:leave="transition ease-in duration-75"
						x-transition:leave-start="opacity-100 scale-100"
						x-transition:leave-end="opacity-0 scale-95"
						x-show="!showList"
						class="text-sm text-slate-700 dark:text-slate-300">{{ $hostages->count() }}items hidden</span>
			</x-slot:actions>
		</x-board-elements.category-header>
	</div>
	<div
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="px-4"
			x-show="showList">
		<ul
				role="list"
				class="divide-y divide-gray-100">
			@foreach($hostages as $hostage)
				<x-cards.hostage-card :hostage="$hostage" />
			@endforeach
		</ul>
	</div>
</div>
