@props(['title' => '', 'content' => ''])
<div
		{{ $attributes->merge(['class' => 'divide-y divide-gray-200 overflow-hidden rounded-lg bg-white dark:bg-gray-600 shadow col-span-3']) }}>
	<div class="px-2 py-2 sm:px-4 flex items-center justify-between dark:text-slate-300 dark:bg-gray-700">
		<p>
			{{ $title }}
		</p>
		<div>
			{{ $actions }}

			<button
					@click="open = !open">
				<x-heroicons::mini.solid.chevron-up-down class="w-4 h-4 ml-2" />
			</button>
		</div>

		<!-- Content goes here -->
		<!-- We use less vertical padding on card headers on desktop than on body sections -->
	</div>
	<div
			x-cloak
			x-show="open"
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="px-2 py-2 sm:p-4 dark:bg-gray-700">
		<p class="text-sm text-gray-500 dark:text-slate-300">
			{{ $content }}
		</p>
		<!-- Content goes here -->
	</div>
</div>