@props(['label' => 'Label', 'value'=>null])
<div {{ $attributes->merge(['class' => 'border-t border-gray-100 px-4 py-6 sm:px-0']) }} >
	<dt class="text-sm/6 font-semibold dark-light-text">{{ $label }}</dt>
	<dd class="mt-1 text-sm/6 text-gray-700 sm:mt-2 dark-light-text">{{ $value ?? $slot }}</dd>
</div>