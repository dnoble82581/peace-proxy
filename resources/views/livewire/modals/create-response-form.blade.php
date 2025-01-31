<x-form-layouts.form-layout
		submit="saveResponse"
		description_classes="truncate">
	<x-slot:header>
		Responding to {{ $subjectRequest->user->name }}
	</x-slot:header>
	<x-slot:description>
		{{ $subjectRequest->subject_request }}
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button type="submit">Send</x-buttons.primary-button>
		<x-buttons.primary-button
				wire:click="close()"
				type="button">Cancel
		</x-buttons.primary-button>
	</x-slot:actions>
	<x-textarea
			label="Your Response"
			wire:model="response" />
</x-form-layouts.form-layout>
