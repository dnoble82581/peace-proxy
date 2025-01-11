@props(['hostage' => null])
<div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-800 dark-light-text px-3 py-2 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
	<div class="shrink-0">
		@if($hostage->images()->count())
			<img
					class="size-10 rounded-full"
					src="{{ $hostage->imageUrl() }}"
					alt="Hostage Image">
		@else
			<img
					class="size-10 rounded-full"
					src="{{ $hostage->temporaryImageUrl() }}"
					alt="Hostage Image">
		@endif
	</div>
	<div class="min-w-0 flex-1">
		<a
				href="{{ route('show.associate', ['room' => $hostage->room->id, 'associate' => $hostage]) }}"
				class="focus:outline-none dark-light-text">
			<p class="text-xs font-medium dark-light-text">{{ $hostage->name }}</p>
			<p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $hostage->gender }}</p>
		</a>
	</div>
	<div>
		@if($hostage->weapons === 'Yes')
			<div class="flex items-center gap-3 justify-between">
				<p class="text-xs">Weapon Alert</p>
				<span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
					<span class="relative inline-flex rounded-full h-3 w-3 bg-rose-500"></span>
				</span>
			</div>
		@endif
		@if($hostage->mental_health_history === 'Yes')
			<div class="flex items-center gap-3 justify-between">
				<p class="text-xs">MH Alert</p>
				<span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
					<span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
				</span>
			</div>
		@endif
		@if($hostage->substance_abuse === 'Yes')
			<div class="flex items-center gap-3 justify-between">
				<p class="text-xs">Substance Alert</p>
				<span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
				<span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
			</span>
			</div>
		@endif
		@if($hostage->medical_issues === 'Yes')
			<div class="flex items-center gap-3 justify-between">
				<p class="text-xs">Medical Alert</p>
				<span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
				<span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
			</span>
			</div>
		@endif
	</div>
	<div class="">
		<x-dropdown.dropdown class="">
			<x-slot:trigger>
				<x-heroicons::mini.solid.ellipsis-vertical class="w-5 h-5 text-gray-400 hover:text-gray-500 dark:text-gray-400 dark-light-text" />
			</x-slot:trigger>
			<x-slot:content>
				<x-dropdown.dropdown-link>
					View
				</x-dropdown.dropdown-link>
				<x-dropdown.dropdown-link>
					Edit
				</x-dropdown.dropdown-link>
			</x-slot:content>
		</x-dropdown.dropdown>
	</div>
</div>