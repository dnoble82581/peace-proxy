@props(['buttons' => [], 'clickHandler' => ''])

<div {{ $attributes->merge(['class' => 'ml-8']) }}>
    <span class="isolate inline-flex rounded-md shadow-xs">
        @foreach ($buttons as $button)
		    <button
				    @click="{{ $clickHandler }} = '{{ $button['key'] }}'"
				    {{-- Update status on click --}}
				    type="button"
				    class="relative inline-flex items-center {{ $loop->first ? 'rounded-l-md' : '' }} {{ $loop->last ? 'rounded-r-md' : '' }} px-3 py-2 text-xs font-semibold ring-1 ring-gray-300 ring-inset focus:z-10"
				    :class="{{ $clickHandler }} === '{{ $button['key'] }}'
                    ? 'bg-indigo-100 text-gray-700 hover:bg-indigo-50'
                    : 'bg-white text-gray-900 hover:bg-gray-50'"
		    >
                {{ $button['label'] }}
            </button>
	    @endforeach
    </span>
</div>
