<x-form-layouts.form-layout submit="editWarning">
	<x-slot:header>Create Warning</x-slot:header>
	<x-slot:description>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores autem debitis eaque, error
	                    ex ipsum itaque laudantium, maiores nam neque nulla porro possimus qui quis saepe veniam
	                    voluptas, voluptatibus voluptatum?
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button>Save</x-buttons.primary-button>
		<x-buttons.secondary-button wire:click="$dispatch('modal.close')">Cancel</x-buttons.secondary-button>
	</x-slot:actions>
	<x-select
			label="Warning Type"
			wire:model="warning_type"
			:options="[
				'Weapons',
				'Vehicles',
				'Mental Health',
				'Suicide By Cop',
				'Other',
			]" />
	<x-input
			label="Warning"
			wire:model="warningText" />
</x-form-layouts.form-layout>

