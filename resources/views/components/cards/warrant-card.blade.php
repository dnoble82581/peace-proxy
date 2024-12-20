@props(['warrant'])
<li
		x-data="{ details: false }"
		class="dark:bg-gray-700 rounded shadow mt-3">
	<div class="flex items-center justify-between gap-x-6 p-4">
		<div class="min-w-0">
			<div class="flex items-start gap-x-3">
				<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300 capitalize">{{ $warrant->offense }}</p>
				<span class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 capitalize">Confirmed: {{ $warrant->confirmed }}</span>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-slate-300">
				<p class="whitespace-nowrap text-gray-600 dark:text-slate-300">Entered:
					<time datetime="2023-03-17T00:00Z">{{ $warrant->entered_on() }}</time>
				</p>
			</div>
		</div>
		<div class="min-w-0">
			<div class="flex items-start gap-x-3">
				<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">{{ $warrant->originating_agency }}</p>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
				<div class="flex items-center gap-x-2 text-xs/5 text-gray-500">
					<p class="whitespace-nowrap text-gray-500 dark:text-slate-300">
						<span class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 capitalize">Extraditable: {{ $warrant->extraditable }}</span>
					</p>
				</div>
			</div>
		</div>
		<div
				class="flex flex-none items-center gap-x-4">
			<span class="sr-only">, GraphQL API</span>
			<div class="relative flex items-center gap-x-2">
				<button
						@click="details = !details"
						:aria-expanded="details.toString()"
						aria-controls="details-content"
						@keydown.enter="details = !details"
						@keydown.space.prevent="details = !details"
						class="focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-blue-500">
					<span class="sr-only">Toggle Details</span>
					<x-heroicons::mini.solid.chevron-up-down class="dark:text-slate-300" />
				</button>
			</div>
		</div>
	</div>
	<div
			x-show="details"
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="border-t border-gray-200 dark:border-slate-700 py-2 px-6">
		<p
				role="region"
				class="text-sm/6 text-gray-600 dark:text-slate-300 bg-gray-50 dark:bg-gray-600 p-4 rounded">
			{{ $warrant->notes }}
		</p>
	</div>
</li>