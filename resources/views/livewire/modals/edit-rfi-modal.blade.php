<x-form-layouts.form-layout submit="updateRfi">
	<x-slot:header>Create RFI</x-slot:header>
	<x-slot:description>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam assumenda fuga minima
	                    molestias, nihil quae quasi sed tempora. Atque deleniti deserunt ea fugiat laborum numquam
	                    placeat repudiandae sunt suscipit velit.
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button>Submit</x-buttons.primary-button>
		<x-buttons.secondary-button wire:click="$dispatch('modal.close')">Cancel</x-buttons.secondary-button>
	</x-slot:actions>
	<x-textarea
			wire:model="request"
			label="RFI"
			name="rfi" />
</x-form-layouts.form-layout>

