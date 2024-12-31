<div>
	<x-form-layouts.form-layout submit="addWarrant">
		<x-slot:header>
			Add Warrant
		</x-slot:header>
		<x-slot:description>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium architecto commodi eius enim error
			esse impedit magni minus molestias nam nemo neque, nesciunt provident rem repudiandae tenetur vero. Ipsam,
			sint!
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button>Save Warrant</x-buttons.primary-button>
			<x-buttons.secondary-button wire:click="$dispatch('modal.close')">Cancel</x-buttons.secondary-button>
		</x-slot:actions>

		<div class="flex items-center gap-4">
			<x-input
					wire:model="form.offense"
					label="Offense"
					placeholder="Enter offense" />
			<x-input
					wire:model="form.originating_agency"
					label="Originating Agency"
					placeholder="Enter originating agency" />
		</div>

		<div class="flex items-center gap-4">
			<x-input
					wire:model="form.originating_county"
					label="Originating County"
					placeholder="Enter originating county" />
			<x-input
					wire:model="form.originating_state"
					label="Originating State"
					placeholder="Enter originating state" />
		</div>

		<div class="flex items-center gap-4">
			<x-input
					wire:model="form.extraditable_warrant"
					label="Extraditable Warrant"
					placeholder="Enter extraditable warrant" />
			<x-datetime-picker
					wire:model="form.entered_on"
					label="Entered On"
					placeholder="Enter entered on"
					without-time="true"
			/>
		</div>


		<x-textarea
				wire:model="form.notes"
				label="Notes"
				placeholder="Enter notes" />

	</x-form-layouts.form-layout>
</div>
