@props([
'type' => "text",
'label' => "",
'placeholder' => "",
'disabled' => false
])

<div class="{{$attributes->get('class')}}">
	<label
			for="{{$attributes->whereStartsWith('wire:model')->first()}}"
			class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{$label}}
	</label>
	<div class="mt-1 relative rounded-md shadow-sm">
		<input
				{{$attributes->whereStartsWith('wire:model')}}
				id="{{$attributes->whereStartsWith('wire:model')->first()}}"
				type="{{$type}}"
				@error($attributes->whereStartsWith('wire:model')->first())
				class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full"
				@else
					class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-full"
				@endif
				placeholder="{{$placeholder}}"
				@error($attributes->whereStartsWith('wire:model')->first())
				aria-invalid="true"
				aria-describedby="email-error"
				@enderror
		/>
		@error($attributes->whereStartsWith('wire:model')->first())
		<div
				wire:key="error_svg_{{$attributes->whereStartsWith('wire:model')->first()}}"
				class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
			<svg
					class="h-5 w-5 text-red-500"
					fill="currentColor"
					viewBox="0 0 20 20">
				<path
						fill-rule="evenodd"
						d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
						clip-rule="evenodd" />
			</svg>
		</div>
		@enderror
		{{--	</div>--}}
		@error($attributes->whereStartsWith('wire:model')->first())
		<p
				wire:key="error_{{$attributes->whereStartsWith('wire:model')->first()}}"
				class="mt-2 text-sm text-red-600"
				id="email-error">{{$message}}
		</p>
		@enderror
	</div>
</div>
