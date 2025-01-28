<div>
	<x-form-layouts.form-layout submit="saveRequest">
		{{ $errors }}
		<x-slot:header>Create Request</x-slot:header>
		<x-slot:description>When creating a subject request, use clear and direct language to
		                    state what you are asking for, ensuring there is no ambiguity. Keep the message concise.
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button type="submit">Create Request</x-buttons.primary-button>
			<x-buttons.secondary-button wire:click="close()">Cancel</x-buttons.secondary-button>
		</x-slot:actions>
		<x-input
				wire:model="form.subject_request"
				label="Request"
				description="A short summary of the request. i.e. 'clothes and cigarettes'" />

		<div class="flex items-center gap-4">
			<x-select
					label="Status"
					wire:model="form.status">
				@foreach($statuses as $status)
					<x-select.option
							label="{{ $status->name }}"
							value="{{ $status->value }}"
							description="{{ $status->metadata()['description'] }}" />
				@endforeach
			</x-select>
			<x-select
					label="Priority"
					wire:model="form.priority_level">
				@foreach($priorities as $priority)
					<x-select.option
							label="{{ $priority->name }}"
							value="{{ $priority->value }}" />
				@endforeach
			</x-select>
			<x-select
					label="Type"
					wire:model="form.type">
				@foreach($types as $type)
					<x-select.option
							label="{{ $type->name }}"
							value="{{ $type->value }}"
							description="{{ $type->metadata()['description'] }}" />
				@endforeach
			</x-select>
		</div>
		<x-textarea
				label="Details"
				wire:model="form.details" />

		<x-textarea
				label="Rationale"
				wire:model="form.rationale"
				description="How will this benefit the negotiations process?" />
	</x-form-layouts.form-layout>
</div>
