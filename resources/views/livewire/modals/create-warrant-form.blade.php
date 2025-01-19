<x-form-layouts.form-layout
		submit="addWarrant"
		class="">
	<x-slot:header>
		Edit Warrant
	</x-slot:header>
	<x-slot:description>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ipsa minus nam officia quia
	                    quidem sint. Ad, delectus ex explicabo fuga fugiat illum itaque iure necessitatibus pariatur
	                    perferendis, rem vel.
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button type="submit">
			Update
		</x-buttons.primary-button>
		<x-buttons.secondary-button wire:click="$dispatch('modal.close')">
			Cancel
		</x-buttons.secondary-button>
	</x-slot:actions>
	<div class="px-3 py-2 space-y-4">
		<div class="flex items-center gap-3">
			<x-input
					label="Offense"
					wire:model="form.offense" />
			<x-input
					label="Originating Agency"
					wire:model="form.originating_agency" />
		</div>

		<div class="flex items-center gap-3">
			<x-input
					label="Originating County"
					wire:model="form.originating_county" />
			<x-input
					label="Originating State"
					wire:model="form.originating_state" />
		</div>

		<div class="flex items-center gap-3">
			<x-select
					label="Extraditable"
					wire:model="form.extraditable"
					:options="['Yes', 'No','Unknown']" />
			<x-select
					label="Confirmed"
					wire:model="form.confirmed"
					:options="['Yes', 'No', 'Unknown']" />
			<x-datetime-picker
					without-time="true"
					label="Entered On"
					wire:model="form.entered_on" />
		</div>

		<x-textarea
				label="Notes"
				wire:model="form.notes" />
	</div>
</x-form-layouts.form-layout>
