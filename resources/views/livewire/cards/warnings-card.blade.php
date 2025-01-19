<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;

	new class extends Component {
		public Subject $subject;

		public function mount($subject):void
		{
			$this->subject = $subject->load('warnings');
		}

		public function addWarning():void
		{
			$this->dispatch('modal.open', component: 'modals.create-warning-form',
				arguments: ['roomId' => $this->subject->room_id]);
		}

		public function getTagLetters($warning)
		{
			$str = $warning->warning_type;
			$pos = strpos($str, ' ');
			return strtoupper($str[0].$str[$pos + 1]);
		}
	}
?>

<div class="px-2">
	<div class="flex justify-end px-4">
		<button wire:click="addWarning">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="grid grid-cols-1 gap-4 sm:grid-cols-3 mt-2">
		@foreach($subject->warnings as $warning)
			<div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-3 py-2 shadow-sm hover:border-gray-400">
				<div class="shrink-0 bg-rose-500 text-white p-2">
					{{ $this->getTagLetters($warning) }}
				</div>
				<div class="min-w-0 flex-1">
					<p class="text-sm font-medium text-gray-900">{{ $warning->warning }}</p>
					<p class="truncate text-sm text-gray-500">{{ $warning->warning_type }}</p>
				</div>
				<x-dropdown.dropdown>
					<x-slot:trigger>
						<button>
							<x-heroicons::mini.solid.ellipsis-vertical class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
						</button>
					</x-slot:trigger>
					<x-slot:content>
						<x-dropdown.dropdown-button>Edit</x-dropdown.dropdown-button>
						<x-dropdown.dropdown-button>Delete</x-dropdown.dropdown-button>
						<x-dropdown.dropdown-button>View</x-dropdown.dropdown-button>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		@endforeach
	</div>
</div>
