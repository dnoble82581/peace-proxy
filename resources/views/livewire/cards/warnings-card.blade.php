<?php

	use App\Events\WarningUpdatedEvent;
	use App\Models\Subject;
	use App\Models\Warning;
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

		public function editWarning($warningId)
		{
			$this->dispatch('modal.open', component: 'modals.edit-warning-form',
				arguments: ['warningId' => $warningId]);
		}

		public function getTagLetters($warning)
		{
			$str = $warning->warning_type;
			$pos = strpos($str, ' ');
			return strtoupper($str[0].$str[$pos + 1]);
		}

		public function getListeners()
		{
			return [
				"echo-presence:warning.{$this->subject->room_id},WarningCreatedEvent" => 'refresh',
				"echo-presence:warning.{$this->subject->room_id},WarningUpdatedEvent" => 'refresh',
			];
		}

		public function deleteWarning($warningId)
		{
			Warning::findOrFail($warningId)->delete();
			event(new WarningUpdatedEvent($this->subject->room_id));
		}


	}
?>

<div class="px-2">
	<div class="flex justify-end px-4">
		<button wire:click="addWarning">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="grid grid-cols-1 gap-4 sm:grid-cols-4 mt-2">
		@if($subject->warnings->count())
			@foreach($subject->warnings as $warning)
				<div class="relative flex items-center space-x-3 col-span-2 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 px-3 py-2 shadow-sm hover:border-gray-400">
					<div class="shrink-0 bg-rose-500 text-white p-2">
						{{ $this->getTagLetters($warning) }}
					</div>
					<div class="min-w-0 flex-1">
						<p class="text-sm font-medium dark-light-text">{{ $warning->warning }}</p>
						<p class="truncate text-sm dark-light-text">{{ $warning->warning_type }}</p>
					</div>
					<x-dropdown.dropdown>
						<x-slot:trigger>
							<button>
								<x-heroicons::mini.solid.ellipsis-vertical class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
							</button>
						</x-slot:trigger>
						<x-slot:content>
							<x-dropdown.dropdown-button wire:click="editWarning({{ $warning->id }})">Edit
							</x-dropdown.dropdown-button>
							<x-dropdown.dropdown-button wire:click="deleteWarning({{ $warning->id }})">Delete
							</x-dropdown.dropdown-button>
						</x-slot:content>
					</x-dropdown.dropdown>
				</div>
			@endforeach
		@else
			<div class="h-full col-span-3">
				<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Warnings</h3>
			</div>
		@endif
	</div>
</div>
