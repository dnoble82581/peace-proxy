@props(['value' => '', 'bgColor' => null, 'action' => null])
<button
		wire:click="{{ $action }}"
		class="{{ $bgColor ?: 'bg-[#252525]' }} {{ $bgColor ? 'hover:bg-indigo-600' : 'hover:bg-[#3a3a3a]' }} text-sm tracking-tight font-semibold px-2 transition-colors rounded py-2 flex-1 text-white h-10"
		type="button">
	{{ $value ?? $slot }}
</button>