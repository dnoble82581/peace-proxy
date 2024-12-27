@props(['header' => 'User Form', 'description' => 'Form Description', 'submit' => 'save', 'actions' => ''])
<form
		wire:submit.prevent="{{ $submit }}"
		{{ $attributes->merge(['class' => 'space-y-8 mt-4 max-w-7xl mx-auto']) }}>
	<div class="p-4 border-b border-gray-200 bg-gray-50">
		<h3 class="text-base font-semibold text-gray-900">
			{{ $header }}
			<p class="mt-2 text-sm text-gray-500">{{ $description }}</p>
		</h3>
	</div>
	<div class="p-4 space-y-4">
		{{ $slot }}
	</div>
	<div class="flex justify-end p-4 space-x-4 border-t border-gray-200 bg-gray-50">
		{{ $actions }}
	</div>
</form>