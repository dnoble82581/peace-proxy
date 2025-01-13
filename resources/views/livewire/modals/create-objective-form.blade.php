<div>
	<x-form-layouts.form-layout submit="createObjective">
		<x-slot:header>Add Objective</x-slot:header>
		<x-slot:description>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus dicta, distinctio ducimus eaque enim est,
			explicabo illum incidunt ipsam ipsum laboriosam laudantium nobis quae, qui quod recusandae saepe sunt
			voluptatibus?
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button type="submit">Save</x-buttons.primary-button>
			<x-buttons.secondary-button type="button">Cancel</x-buttons.secondary-button>
		</x-slot:actions>
		<x-select
				label="Priority"
				wire:model="priority"
				:options="[
                    ['name' => 'High', 'id' => 1],
                    ['name' => 'Medium', 'id' => 2],
                    ['name' => 'Low', 'id' => 3],
                ]"
				option-label="name"
				option-value="id" />
		<x-input
				label="Objective"
				wire:model="objective" />
	</x-form-layouts.form-layout>
</div>
