<div class="dark:bg-gray-800">
	<div class="pl-4 pt-4 bg-white dark:text-slate-300 dark:bg-gray-800">
		<h3 class="text-base font-semibold text-gray-900 dark:text-slate-300">Create Demand</h3>
		<p class="mt-1 text-sm text-gray-500 dark:text-slate-300">Lorem ipsum dolor sit amet consectetur adipisicing
		                                                          elit quam corrupti
		                                                          consectetur.</p>
	</div>
	<x-errors />
	<form wire:submit.prevent="updateDemand">
		<div class="p-4 space-y-4 dark:bg-gray-800">
			<x-input
					label="Title"
					value="{{ old('title') }}"
					wire:model="title" />
			<div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
				<x-select
						label="Status"
						value="{{ old('status') }}"
						wire:model="status"
						placeholder="Deadline"
						:options="['Closed', 'Pending', 'Approved', 'Rejected']" />
				<x-select
						label="Type"
						value="{{ old('type') }}"
						wire:model="type"
						placeholder="Demand Type"
						:options="[
						['name' => 'Substantive', 'id' => '1', 'description' => 'Demand is related directly to motivation and resolution'],
						['name' => 'Expressive', 'id' => '2', 'description' => 'Provides insight into subjects emotional status and behavior'],
						['name' => 'Secondary', 'id' => '3', 'description' => 'Demands such as food, cigarettes, or beer are not substantive.']
						]"
						option-label="name"
						option-value="name" />
			</div>

			<x-datetime-picker
					wire:model="deadline"
					label="Deadline" />
			<x-textarea
					label="Description"
					wire:model="description" />
			<x-textarea
					label="Notes"
					wire:model="notes" />
		</div>
		<div class="flex justify-end p-4 space-x-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-800 dark:text-slate-300">
			<x-buttons.primary-button :value="__('Update Demand')" />
			<x-buttons.secondary-button
					:value="__('Cancel')"
					wire:click="$dispatch('modal.close')" />
		</div>
	</form>
</div>
