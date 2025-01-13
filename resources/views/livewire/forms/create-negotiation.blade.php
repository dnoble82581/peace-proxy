<?php

	use App\Livewire\Forms\NegotiationForm;
	use Livewire\Volt\Component;

	new class extends Component {
		public NegotiationForm $form;

		public function create()
		{
			$this->form->save();
			return redirect(route('dashboard'));
		}
	}

?>

<x-form-layouts.form-layout submit="create">
	<x-slot:header>Create a New Negotiation</x-slot:header>
	<x-slot:description>Create a new negotiation</x-slot:description>

	{{--		Form Inputs--}}
	<div class="grid grid-cols-1 sm:grid-cols-6 gap-4">

		<x-dividers.form-divider>Negotiation Information</x-dividers.form-divider>

		<x-select
				wire:model="form.type"
				class="col-span-1 sm:col-span-2"
				description="Required"
				label="Type"
				placeholder="Negotiation Type"
				:options="['Live', 'Practice']" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Required"
				label="Title"
				wire:model="form.title" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Address"
				wire:model="form.address" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Required"
				label="City"
				wire:model="form.city" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Required"
				label="State"
				wire:model="form.state" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Zip"
				wire:model="form.zip" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Initial Complainant"
				wire:model="form.initial_complainant" />

		<x-dividers.form-divider>Subject Information</x-dividers.form-divider>

		{{--		Subject Inputs--}}
		<x-input
				class="col-span-1 sm:col-span-2"
				description="Defaults to John Doe"
				label="Subject Name"
				wire:model="form.subject_name" />
		<x-input
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Subject Phone"
				wire:model="form.subject_phone" />
		<x-select
				wire:model="form.subject_sex"
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Subject Sex"
				placeholder="Subject Sex"
				:options="['Male', 'Female', 'Transgender', 'Unknown']" />

		<x-input
				class="col-span-1 sm:col-span-2"
				description="Optional"
				label="Subject Age"
				wire:model="form.subject_age" />

		<x-dividers.form-divider>Details</x-dividers.form-divider>

		{{--Place Holder --}}
		<div class="col-span-4"></div>

		<x-textarea
				class="col-span-1 sm:col-span-3"
				description="Optional"
				label="Initial Complainant"
				wire:model="form.initial_complaint" />

		<x-textarea
				class="col-span-1 sm:col-span-3"
				description="Optional"
				label="Subject Motivation"
				wire:model="form.subject_motivation" />
	</div>
	<div class="flex items-center justify-end gap-4">
		<x-svg-images.loading
				wire:loading
				wiretarget="form.save" />
		<x-buttons.primary-button>Save</x-buttons.primary-button>
		<x-buttons.secondary-button>Cancel</x-buttons.secondary-button>
	</div>
</x-form-layouts.form-layout>
