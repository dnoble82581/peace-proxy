@props(['value' => null, 'clickAction' => null, 'actions' => null, 'search' => null])
<div {{ $attributes->merge(['class' => 'rounded-lg p-2 shadow-md']) }}>
	<div class="flex items-center justify-between">
		<div class="flex items-center space-x-2">
			<p class="font-semibold block w-20 text-gray-600 dark:text-slate-300">{{ $value ?: $slot }}</p>
			{{ $actions }}
		</div>
		<div class="flex items-center gap-5">
			<span class="">
				{{ $search }}
			</span>
			<button
					wire:click="{{ $clickAction }}"
					class="flex items-center">
				<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
			</button>
		</div>

	</div>
</div>