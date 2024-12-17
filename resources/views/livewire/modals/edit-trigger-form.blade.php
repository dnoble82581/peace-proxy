<div>
	<div class="ml-4 mt-4">
		<h3 class="text-base font-semibold text-gray-900">Create Trigger</h3>
		<p class="mt-1 text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit quam corrupti
		                                      consectetur.</p>
	</div>
	<form wire:submit.prevent="updateTrigger">
		<div class="p-4 space-y-4">
			<x-input
					label="Title"
					value="{{ old('title') }}"
					wire:model="title" />
			<x-textarea
					label="Description"
					wire:model="description" />
		</div>
		<div class="flex justify-end p-4 space-x-4 border-t border-gray-200 bg-gray-50">
			<x-buttons.primary-button :value="__('Create Hook')" />
			<x-buttons.secondary-button
					:value="__('Cancel')"
					wire:click="$dispatch('modal.close')" />
		</div>
	</form>
</div>