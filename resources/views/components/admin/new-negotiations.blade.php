@php use App\Models\Negotiation; @endphp
<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
	<dt>
		<div class="absolute rounded-md bg-indigo-500 p-3">
			<svg
					class="size-6 text-white"
					fill="none"
					viewBox="0 0 24 24"
					stroke-width="1.5"
					stroke="currentColor"
					aria-hidden="true"
					data-slot="icon">
				<path
						stroke-linecap="round"
						stroke-linejoin="round"
						d="M21.75 9v.906a2.25 2.25 0 0 1-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 0 0 1.183 1.981l6.478 3.488m8.839 2.51-4.66-2.51m0 0-1.023-.55a2.25 2.25 0 0 0-2.134 0l-1.022.55m0 0-4.661 2.51m16.5 1.615a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V8.844a2.25 2.25 0 0 1 1.183-1.981l7.5-4.039a2.25 2.25 0 0 1 2.134 0l7.5 4.039a2.25 2.25 0 0 1 1.183 1.98V19.5Z" />
			</svg>
		</div>
		<p class="ml-16 truncate text-sm font-medium text-gray-500">New Negotiations</p>
	</dt>
	<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
		<p class="text-2xl font-semibold text-gray-900">{{ $this->retrieveRecords(new Negotiation(), 30)->count()}}</p>
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
			{{ $this->user->tenant->getUserPercentageChange()  }}%
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