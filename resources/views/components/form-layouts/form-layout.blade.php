@props(['header' => 'User Form', 'description' => 'Form Description', 'submit' => 'save', 'actions' => ''])
<form
		wire:submit.prevent="{{ $submit }}"
		{{ $attributes->merge(['class' => 'space-y-8 max-w-7xl mx-auto dark:bg-gray-800']) }}>
	<div class="px-4 border-b border-gray-200 bg-gray-50 dark-light-text dark:bg-gray-800">
		<h3 class="text-base font-semibold dark-light-text py-2">
			{{ $header }}
			<p class="mt-2 text-sm dark-light-text font-normal">{{ $description }}</p>
		</h3>
	</div>
	<div class="p-4 space-y-4">
		{{ $slot }}
	</div>
	<div class="flex justify-end p-4 space-x-4 border-t border-gray-200 bg-gray-50">
		{{ $actions }}
	</div>
</form>