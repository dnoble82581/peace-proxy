@props(['header' => 'User Form', 'description' => 'Form Description', 'submit' => 'save'])
<form wire:submit.prevent="{{ $submit }}">
	<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-8">
		{{ $header }}
		<p class="mt-2 text-sm text-gray-500">{{ $description }}</p>
	</h2>
	{{ $slot }}
</form>