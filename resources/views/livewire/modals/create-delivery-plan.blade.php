<x-form-layouts.form-layout submit="saveDeliveryPlan">
	<x-errors />
	<x-slot:header>
		Create Delivery Plan
	</x-slot:header>
	<x-slot:description>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet asperiores, deleniti est exercitationem
		impedit maxime modi odio quae quaerat quas repellendus vero voluptas! Consequatur earum facilis molestias nemo
		vel.
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button type="submit">create</x-buttons.primary-button>
		<x-buttons.secondary-button wire:click="$dispatch('modal.close')">cancel</x-buttons.secondary-button>
	</x-slot:actions>

	<x-input
			label="Title"
			wire:model="title" />
	<x-input
			label="Delivery Location"
			wire:model="delivery_location" />
	<x-textarea
			label="Special Instructions"
			wire:model="special_instructions" />
	<x-textarea
			label="Delivery Notes"
			wire:model="notes" />
	<div>
		<x-label
				class="mb-2"
				for="documents">Documents
		</x-label>
		<x-form-elements.file-input
				multiple
				id="documents"
				wire-to="documents"
				accepted-types="application/pdf"
				label="Upload File" />
	</div>
</x-form-layouts.form-layout>