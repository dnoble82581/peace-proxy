<div class="dark:bg-gray-800">
	<div class="pl-4 pt-4 bg-white dark:text-slate-300 dark:bg-gray-800">
		<h3 class="text-base font-semibold text-gray-900 dark:text-slate-300">Job Postings</h3>
		<p class="mt-1 text-sm text-gray-500 dark:text-slate-300">Lorem ipsum dolor sit amet consectetur adipisicing
		                                                          elit quam corrupti
		                                                          consectetur.</p>
	</div>
	<form wire:submit.prevent="createHook">
		<div class="p-4 space-y-4 dark:bg-gray-800">
			<x-input
					label="Title"
					value="{{ old('title') }}"
					wire:model="title" />
			<x-textarea
					label="Description"
					wire:model="description" />
		</div>
		<div class="flex justify-end p-4 space-x-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-800 dark:text-slate-300">
			<x-buttons.primary-button :value="__('Create Hook')" />
			<x-buttons.secondary-button
					:value="__('Cancel')"
					wire:click="$dispatch('modal.close')" />
		</div>
	</form>
</div>
