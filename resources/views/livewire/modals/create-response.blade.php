<div>
	<x-errors />
	<x-form-layouts.form-layout submit="saveResponse">
		<x-slot:header>Creat Response</x-slot:header>
		<x-slot:description>
			You are responding to a demand: {{ $demand->title }} submitted on {{ $demand->created_at->format('d M Y') }}
			.
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button type="submit">Create</x-buttons.primary-button>
			<x-buttons.secondary-button wire:click="cancel">Cancel</x-buttons.secondary-button>
		</x-slot:actions>
		<x-textarea
				wire:model="responseBody"
				label="Response"
				name="response" />
	</x-form-layouts.form-layout>
</div>
