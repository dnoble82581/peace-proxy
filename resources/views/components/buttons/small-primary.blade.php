@props(['disabled' => false, 'label' => ''])
<button
		{{ $attributes->merge(['class' => 'rounded px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors ease-in-out']) }}
		type="button">
	{{ $label ?: $slot }}
</button>