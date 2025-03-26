<div
		x-data="{search: false}"
		class="flex items-center space-x-2">
	<div
			class="reusable-transition"
			x-bind:class="{ hidden: !search }"
			x-show="search"
	>
		<label
				for="search"
				class="sr-only">Search</label>
		<input
				x-cloak
				id="search"
				type="text"
				placeholder="{{ $placeholder ?? 'Search' }}"
				wire:model.live.debounce.300ms="{{ $field }}"
				class="h-6 focus:ring-0 rounded-lg text-sm"
		/>
	</div>
	<div>
		<button
				@click="search = ! search"
				class="flex">
			<x-heroicons::micro.solid.magnifying-glass class="w-8 h-5 text-gray-600 dark:text-slate-300" />
		</button>
	</div>
</div>