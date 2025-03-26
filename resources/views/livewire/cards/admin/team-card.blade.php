<?php

	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;
	use App\Models\User;

	new class extends Component {
		public Collection $users;
		public string $search = '';
		public bool $sortAscending = true;
		public bool $sortStatus = true;
		public bool $sortCreated = true;
		public bool $sortEmail = true;
		public string $currentFilter = '';

		public function mount():void
		{
			$this->users = $this->fetchUsers();
		}

		private function fetchUsers():Collection
		{
			return User::query()
				->when($this->search, function ($query) {
					$query->where('name', 'like', '%'.$this->search.'%')
						->orWhere('email', 'like', '%'.$this->search.'%');
				})
				->select(['id', 'name', 'email', 'primary_phone', 'avatar', 'status', 'privileges'])
				->get();
		}

		public function updatedSearch():void
		{
			$this->users = $this->fetchUsers();
		}

		public function sortAlphabetically():void
		{
			if ($this->sortAscending) {
				// Sort ascending
				$this->users = $this->users->sortBy('name')->values();
				$this->currentFilter = 'Filtered: A to Z';
			} else {
				// Sort descending
				$this->users = $this->users->sortByDesc('name')->values();
				$this->currentFilter = 'Filtered: Z to A';

			}

			// Toggle the sorting direction for the next click
			$this->sortAscending = !$this->sortAscending;
			// Sort by name alphabetically
		}

		public function sortByCreated():void
		{
			if ($this->sortCreated) {
				// Sort ascending
				$this->users = $this->users->sortBy('created_at')->values();
				$this->currentFilter = 'Filtered: Joined First';

			} else {
				// Sort descending
				$this->users = $this->users->sortByDesc('created_at')->values();
				$this->currentFilter = 'Filtered: Joined Last';

			}

			// Toggle the sorting direction for the next click
			$this->sortCreated = !$this->sortCreated;
			// Sort by name alphabetically
		}

		public function sortByEmail():void
		{
			if ($this->sortEmail) {
				// Sort ascending
				$this->users = $this->users->sortBy('email')->values();
				$this->currentFilter = 'Filtered: Email A to Z';

			} else {
				// Sort descending
				$this->users = $this->users->sortByDesc('email')->values();
				$this->currentFilter = 'Filtered: Email Z to A';

			}

			// Toggle the sorting direction for the next click
			$this->sortEmail = !$this->sortEmail;
			// Sort by name alphabetically
		}

		public function sortByStatus():void
		{
			if ($this->sortStatus) {
				// Sort ascending
				$this->users = $this->users->sortBy('status')->values();
				$this->currentFilter = 'Filtered: Status Active First';

			} else {
				// Sort descending
				$this->users = $this->users->sortByDesc('status')->values();
				$this->currentFilter = 'Filtered: Status Inactive First';

			}

			// Toggle the sorting direction for the next click
			$this->sortStatus = !$this->sortStatus;
			// Sort by name alphabetically
		}

		public function clearFilters():void
		{
			$this->search = '';
			$this->users = $this->fetchUsers();
			$this->currentFilter = '';
		}
	}

?>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-8 lg:grid-cols-12">
	<div class="bg-[#1a1a1b] p-4 rounded-md col-span-full">
		<div class="grid grid-cols-12 gap-4 relative">
			<div class="relative col-span-6">
				<x-input
						wire:model.live.debounce.300ms="search"
						id="search"
						icon="magnifying-glass">
					<x-slot
							name="label"
							class="text-white font-semibold mb-1">
						Search
					</x-slot>
				</x-input>
			</div>

			<div class="gap-2 col-span-6 flex mt-7">
				<x-buttons.admin.filter-button
						action="sortAlphabetically"
						value="Alphabetical" />
				<x-buttons.admin.filter-button
						action="sortByStatus"
						value="Status" />
				<x-buttons.admin.filter-button
						action="sortByCreated"
						value="Joined" />
				<x-buttons.admin.filter-button
						action="sortByEmail"
						value="Email" />
				<x-buttons.admin.filter-button
						bgColor="bg-indigo-500"
						action="clearFilters"
						value="Reset Filters" />
				<span class="absolute text-sm text-[#dddddd] top-0 right-3">{{ $currentFilter }}</span>
			</div>
		</div>
	</div>
	@foreach($users as $user)
		<div class="w-full lg:col-span-3 max-w-sm bg-[#1a1a1b] rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
			<div class="flex justify-end px-4 pt-4">
				<x-dropdown.dropdown contentClasses="bg-[#2e2e2e]">
					<x-slot:trigger>
						<button>
							<x-heroicons::mini.solid.ellipsis-vertical class="w-5 h-5 text-[#dddddd]" />
						</button>
					</x-slot:trigger>
					<x-slot:content>
						<a
								href='{{ route('edit.user', ['id' => (int) $user->id]) }}'
								target="_blank"
								class='block w-full px-4 py-2 text-start rounded-t-lg text-sm leading-5 text-[#dddddd]  hover:bg-[#3a3a3a]  focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'>
							Edit
						</a>
						<button class='block w-full px-4 py-2 text-start rounded-b-lg text-sm leading-5 text-rose-500  hover:bg-[#3a3a3a]  focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out'>
							Delete
						</button>
					</x-slot:content>
				</x-dropdown.dropdown>

			</div>
			<div class="flex flex-col items-center">
				<img
						class="w-24 h-24 mb-3 rounded-full shadow-lg"
						src="{{ $user->avatarUrl() }}"
						alt="Bonnie image" />
				<h5 class="mb-1 text-xl font-medium text-[#dddddd]">{{ $user->name }}</h5>
				<span class="text-sm text-gray-500 dark:text-gray-400 capitalize">{{ $user->privileges }}</span>
			</div>
			<div class="px-2 sm:px-6 pb-10">
				<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
					<x-heroicons::micro.solid.phone class="w-5 h-5" />
					<span>{{ $user->primary_phone }}</span>
				</div>
				<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
					<x-heroicons::mini.solid.envelope class="w-5 h-5" />
					<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
				</div>
				<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
					<x-heroicons::mini.solid.user class="w-5 h-5" />
					<span>{{ $user->status ? 'Active' : 'Inactive' }}</span>
				</div>
			</div>
		</div>
	@endforeach
</div>
