@props(['document' => null])
<li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm/6">
	<div class="flex w-0 flex-1 items-center">
		<x-svg-images.paper-clip />
		<div class="ml-4 flex min-w-0 flex-1 gap-2">
			<span class="truncate font-medium">{{ $document->offense ?? 'Offense'}}</span>
			<span class="shrink-0 text-gray-400">2.4mb</span>
		</div>
	</div>
	<div class="ml-4 shrink-0">
		<a
				href="#"
				class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-white dark:bg-indigo-500 dark:px-2 rounded-md dark:py-1 dark:hover:bg-indigo-600">View</a>
	</div>
</li>