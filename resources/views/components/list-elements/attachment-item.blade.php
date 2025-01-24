@props(['document' => null])
<li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6">
	<div class="flex w-0 flex-1 items-center">
		<x-heroicons::outline.paper-clip class="shrink-0 h-5 w-5 text-gray-400" />
		<div class="ml-4 flex min-w-0 flex-1 gap-2">
			<span class="truncate font-medium capitalize">{{ $document->offense ?? $document->filename}}</span>
			<span class="shrink-0 text-gray-400">2.4mb</span>
		</div>
	</div>
	<div class="ml-4 shrink-0">
		@if($document->filename)
			<a
					href="{{ $document->privateUrl() }}"
					target="_blank"
					class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-white dark:bg-indigo-500 dark:px-2 rounded-md dark:py-1 dark:hover:bg-indigo-600">
				Download
			</a>
		@else
			<button
					onclick="Livewire.dispatch('modal.open', {component:'modals.show-warrant', arguments: {'warrantId': '{{ $document->id }}'}})"
					class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-white dark:bg-indigo-500 dark:px-2 rounded-md dark:py-1 dark:hover:bg-indigo-600">
				View
			</button>
		@endif

	</div>
</li>