<?php

	use App\Models\Room;
	use Livewire\Volt\Component;

	new class extends Component {
		public Room $room;

		public function mount($room)
		{
			$this->room = $room;
		}

		public function addRequest()
		{
			$this->dispatch('modal.open', component: 'modals.create-request-modal', arguments: [$this->room->id]);
		}
	}

?>
<div>
	<div class="flex justify-end px-4 mt-2">
		<button wire:click="addRequest">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<ul
			role="list"
			class="divide-y divide-gray-100 px-8">
		<li class="flex items-center justify-between gap-x-6 py-5">
			<div class="min-w-0">
				<div class="flex items-start gap-x-3">
					<p class="text-sm/6 font-semibold text-gray-900">GraphQL API</p>
					<p class="mt-0.5 rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium whitespace-nowrap text-green-700 ring-1 ring-green-600/20 ring-inset">
						Complete</p>
				</div>
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
					<p class="whitespace-nowrap">Created
						<time datetime="2023-03-17T00:00Z">March 17, 2023</time>
					</p>
					<svg
							viewBox="0 0 2 2"
							class="size-0.5 fill-current">
						<circle
								cx="1"
								cy="1"
								r="1" />
					</svg>
					<p class="truncate">Created by Leslie Alexander</p>
				</div>
			</div>
			<div class="min-w-0">
				<x-buttons.small-primary
						label="View Response(4)"
						class="bg-indigo-500 hover:bg-indigo-600 text-sm/6 font-semibold" />
				<div class="text-xs/5 text-gray-500 mt-1">
					Responded to by Crhis Wisman 30s ago.
				</div>
			</div>
			<div class="flex flex-none items-center gap-x-4">
				<div class="relative flex-none">
					<x-dropdown.dropdown>
						<x-slot:trigger>
							<button>
								<x-heroicons::micro.solid.ellipsis-vertical class="w-5 h-5 text-gray-400 hover:text-gray-500" />
							</button>
						</x-slot:trigger>
						<x-slot:content>
							<x-dropdown.dropdown-button>Test</x-dropdown.dropdown-button>
						</x-slot:content>
					</x-dropdown.dropdown>
				</div>
			</div>
		</li>
	</ul>
</div>


