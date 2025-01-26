@props(['objective'])
<li
		class="flex items-center justify-between gap-x-6 px-10 py-2">
	<div class="min-w-0">
		<div class="flex items-start gap-x-3">
			<p class="text-sm/6 font-semibold dark-light-text">{{ $objective->objective }}</p>
			@if($objective->status === 'Complete')
				<p class="mt-0.5 whitespace-nowrap rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
					Complete</p>
				<p class="mt-0.5 whitespace-nowrap rounded-md bg-slate-50 px-1.5 py-0.5 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20">
					{{ $objective->updated_at->format('M d Y') }}</p>
			@elseif($objective->status === 'In Progress')
				<p class="mt-0.5 whitespace-nowrap rounded-md bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">
					In Progress</p>
				@if($objective->priority == 1)
					<p class="mt-0.5 whitespace-nowrap rounded-md bg-red-50 px-1.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">
						{{ $objective->getPriorityString($objective->priority) }}</p>
				@elseif($objective->priority == 2)
					<p class="mt-0.5 whitespace-nowrap rounded-md bg-yellow-50 px-1.5 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-inset ring-yellow-600/20">
						{{ $objective->getPriorityString($objective->priority) }}</p>
				@elseif($objective->priority == 3)
					<p class="mt-0.5 whitespace-nowrap rounded-md bg-sky-50 px-1.5 py-0.5 text-xs font-medium text-sky-700 ring-1 ring-inset ring-sky-600/20">
						{{ $objective->getPriorityString($objective->priority) }}</p>
				@endif
			@endif

		</div>
		<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-gray-400">
			<p class="whitespace-nowrap">Created on
				<time datetime="2023-03-17T00:00Z">{{ $objective->created_at->format('M d Y') }}</time>
			</p>
			<svg
					viewBox="0 0 2 2"
					class="size-0.5 fill-current">
				<circle
						cx="1"
						cy="1"
						r="1" />
			</svg>
			<p class="truncate">By {{ $objective->user->name }}</p>
		</div>
	</div>
	<div class="flex flex-none items-center gap-x-4">
		<button
				wire:click="toggleComplete({{ $objective->id }})"
				class="{{ $objective->status === 'Complete' ? 'text-green-500' : 'text-gray-700 dark:text-gray-500' }}">
			<x-heroicons::mini.solid.check />
		</button>
		<button
				wire:click="deleteObjective({{ $objective->id }})"
				class="text-red-400">
			<x-heroicons::outline.trash class="w-5 h-5" />
		</button>
		<button
				wire:click="editObjective({{ $objective->id }})"
				class="text-blue-400">
			<x-heroicons::outline.pencil-square class="w-5 h-5" />
		</button>
	</div>
</li>