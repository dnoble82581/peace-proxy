<x-form-layouts.form-layout submit="saveDeliveryPlan">
	<x-errors />
	<x-slot:header>
		{{ $this->plan ? 'Edit Plan' : 'Create Plan' }}
	</x-slot:header>
	<x-slot:description>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet asperiores, deleniti est exercitationem
		impedit maxime modi odio quae quaerat quas repellendus vero voluptas! Consequatur earum facilis molestias nemo
		vel.
	</x-slot:description>
	<x-slot:actions>
		<x-buttons.primary-button type="submit">{{ $this->plan ? 'Save' : 'Create' }}</x-buttons.primary-button>
		<x-buttons.secondary-button wire:click="$dispatch('modal.close')">cancel</x-buttons.secondary-button>
	</x-slot:actions>

	<x-input
			label="Title"
			wire:model="title" />
	<x-input
			label="Location"
			wire:model="delivery_location" />
	<x-textarea
			label="Special Instructions"
			wire:model="special_instructions" />
	<x-textarea
			label="Notes"
			wire:model="notes" />
	<div class="flex items-center gap-4">
		@if($old_documents)
			@foreach($old_documents as $document)
				<div>
					<x-heroicons::outline.paper-clip class="w-6 h-6" />
					<p class="text-xs">{{ $document->type }}</p>
					<button wire:click="deleteDocument({{ $document->id }})">
						<x-heroicons::outline.trash class="size-4 text-red-500" />
					</button>
					<a
							class="inline-flex"
							href="{{ $document->privateUrl() }}"
							target="_blank">
						<x-heroicons::outline.envelope-open class="size-4 text-blue-500" />
					</a>
				</div>
			@endforeach
		@endif
	</div>
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