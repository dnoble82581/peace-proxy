@props(['value' => null, 'clickAction' => null, 'actions' => null])
<div {{ $attributes->merge(['class' => 'rounded-lg p-2 shadow-md']) }}>
	<div class="flex items-center justify-between">
		<div class="flex items-center space-x-2">
			<p class="font-semibold text-slate-700 dark:text-slate-300">{{ $value ?: $slot }}</p>
			{{ $actions }}
		</div>
		<button wire:click="{{ $clickAction }}">
			<x-heroicons::mini.solid.plus class="w-5 h-5 text-slate-700 dark:text-slate-300" />
		</button>
	</div>
</div>