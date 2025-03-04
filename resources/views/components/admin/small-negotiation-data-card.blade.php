@props(['tenant'])
<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
	<dt>
		<div class="absolute rounded-md bg-indigo-500 p-3">
			<x-heroicons::outline.chat-bubble-left-right class="size-6 text-white" />
		</div>
		<p class="ml-16 truncate text-sm font-medium text-gray-500">Negotiations</p>
	</dt>
	<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
		<p class="text-2xl font-semibold text-gray-900">{{ $tenant->getRecentNegotiations(30) }}</p>
		<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
			<svg
					class="size-5 shrink-0 self-center text-green-500"
					viewBox="0 0 20 20"
					fill="currentColor"
					aria-hidden="true"
					data-slot="icon">
				<path
						fill-rule="evenodd"
						d="M10 17a.75.75 0 0 1-.75-.75V5.612L5.29 9.77a.75.75 0 0 1-1.08-1.04l5.25-5.5a.75.75 0 0 1 1.08 0l5.25 5.5a.75.75 0 1 1-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0 1 10 17Z"
						clip-rule="evenodd" />
			</svg>
			<span class="sr-only"> Increased by </span>
			{{ $tenant->getNegotiationPercentageChange() }}%
		</p>
		<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
			<div class="text-sm">
				<a
						href="#"
						class="font-medium text-indigo-600 hover:text-indigo-500">View
				                                                                  all<span class="sr-only"> Avg. Open Rate stats</span></a>
			</div>
		</div>
	</dd>
</div>