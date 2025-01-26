@props(['label' => null, 'clickAction' => null, 'leftActions' => null, '$rightActions' => null, 'search' => null])
<div {{ $attributes->merge(['class' => 'rounded-lg p-2 shadow-md']) }}>
	<div class="flex items-center justify-between">
		<div class="flex items-center space-x-2">
			<p class="font-semibold block w-20 text-gray-600 dark:text-slate-300">{{ $label ?: $slot }}</p>
			{{ $leftActions ?? '' }}
		</div>
		<div class="flex items-center gap-2 px-2">
			{{ $rightActions ?? '' }}
		</div>
	</div>
</div>