@props(['value' => null, 'color' => ''])
<p {{ $attributes->merge(['class' => "mt-0.5 inline-block capitalize whitespace-nowrap rounded-md px-1.5 py-0.5 text-xs font-medium $color"]) }}>
	{{ $value ?? $slot }}
</p>