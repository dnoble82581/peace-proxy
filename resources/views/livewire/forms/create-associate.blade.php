<?php


	use App\Events\AssociateCreatedEvent;
	use App\Events\AssociateEvent;
	use App\Livewire\Forms\AssociateForm;
	use App\Models\Room;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;

	new class extends Component {
		use WithFileUploads;

		public AssociateForm $form;
		public Room $room;

		public function mount($roomId)
		{
			$this->room = $this->getRoom($roomId);
		}

		public function getRoom($roomId)
		{
			return Room::findOrFail($roomId);
		}

		public function cancel()
		{
			return redirect(route('negotiation.room', $this->room));
		}

		public function saveassociate():void
		{
			$this->form->create($this->room);
			$this->redirect(route('negotiation.room', $this->room->id));
		}
	}

?>

<div class="mt-5 pb-8">
	<x-form-layouts.form-layout
			class="bg-white"
			submit="saveassociate">
		<x-slot:header>Edit Associate</x-slot:header>
		<x-slot:description>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae dolore minus natus
		                    necessitatibus odio possimus quam sed temporibus, voluptate? Accusamus asperiores aspernatur
		                    beatae dolorem ipsum laborum libero nisi numquam possimus?
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button
					type="submit"
					:value="__('Save')" />
			<x-buttons.secondary-button
					wire:click="cancel"
					type="button"
					:value="__('Cancel')" />
		</x-slot:actions>
		<x-dividers.form-divider class="py-4 font-bold">General</x-dividers.form-divider>

		<div class="grid grid-cols-1 sm:grid-cols-6 gap-6">
			<x-input
					wire:model="form.name"
					class="sm:col-span-2"
					label="Name"
					placeholder="Name" />
			<x-input
					wire:model="form.email"
					class="sm:col-span-2"
					label="Email"
					placeholder="Email" />
			<x-phone
					class="sm:col-span-2"
					wire:model="form.phone"
					label="Phone"
					label="Phone"
					:mask="['(###) ###-####', '+# ### ###-####', '+## ## ####-####']"
					placeholder="Phone" />
			<x-input
					wire:model="form.address"
					class="sm:col-span-3"
					label="Address"
					placeholder="Address" />
			<x-input
					wire:model="form.city"
					class="sm:col-span-1"
					label="City"
					placeholder="City" />
			<x-input
					wire:model="form.state"
					class="sm:col-span-1"
					label="State"
					placeholder="State" />
			<x-input
					wire:model="form.zipcode"
					class="sm:col-span-1"
					label="Zip"
					placeholder="Zip" />

			<x-dividers.form-divider class="py-4 font-bold col-span-6">Details</x-dividers.form-divider>

			<x-select
					class="sm:col-span-2"
					placeholder="Gender"
					wire:model="form.gender"
					label="Associate Gender"
					:options="['Male', 'Female', 'Transgender', 'Unknown']" />
			<x-select
					class="sm:col-span-2"
					wire:model="form.race"
					label="Associate Race"
					placeholder="Associate Race"
					:options="[
					['name' => 'White', 'id' => 'White', 'description' => '(Europe, Middle East, North Africa)'],
					['name' => 'Mongoloid', 'id' => 'Mongoloid', 'description' => '(East Asia, Central Asia, Indigenous peoples of the Americas)'],
					['name' => 'Negroid', 'id' => 'Negroid', 'description' => '(Sub-Saharan Africa)'],
					['name' => 'Australoid', 'id' => 'Australoid', 'description' => '(Indigenous Australians, Papuans)'],
					['name' => 'Mixed-race', 'id' => 'Mixed-race', 'description' => '(People with heritage from multiple groups)'],
					['name' => 'Other Ethnic Groupings', 'id' => 'Other Ethnic Groupings', 'description' => '(South Asian, Middle Eastern, etc.)'],
				]"
					option-label="name"
					option-value="id" />

			<x-select
					wire:model="form.relationship_to_subject"
					class="col-span-2"
					label="Search Relationships"
					placeholder="Select Relationship"
					:async-data="route('api.relationships.index')"
					option-label="relationship"
					option-value="relationship"
					option-description="description"
			/>

			<x-select
					wire:model="form.children"
					placeholder="Children"
					class="sm:col-span-2"
					label="Children"
					:options="[1,2,3,4,5,6,7,8,9,10]" />
			<x-select
					wire:model="form.veteran"
					class="sm:col-span-2"
					label="Veteran"
					:options="['Yes', 'No', 'Unknown']" />
			<x-select
					wire:model="form.highest_education"
					class="sm:col-span-2"
					label="Highest Education"
					placeholder="Highest Education"
					:options="['Grade School', 'High School', 'College', 'Graduate', 'Unknown']" />
			<x-datetime-picker
					label="Date of Birth"
					class="sm:col-span-2"
					wire:model="form.dob"
					:max="now()"
					without-time="true" />
			<x-input
					wire:model="form.age"
					class="sm:col-span-2"
					label="Age"
					placeholder="Subject Age" />

			<x-select
					wire:model="form.substance_abuse"
					class="sm:col-span-2"
					label="Substance Abuse History"
					placeholder="Substance Abuse"
					:options="['Yes', 'No', 'Unknown']" />

			<x-select
					wire:model="form.mental_health_history"
					class="sm:col-span-2"
					label="Mental Health History"
					placeholder="Mental Health History"
					:options="['Yes', 'No', 'Unknown']" />

			<x-select
					wire:model="form.medical_issues"
					class="sm:col-span-2"
					label="Medical Problems"
					placeholder="Medical Problems"
					:options="['Yes', 'No', 'Unknown']" />
			<x-select
					wire:model="form.weapons"
					class="sm:col-span-2"
					label="Known Weapons"
					placeholder="Known Weapons"
					:options="['Yes', 'No', 'Unknown']" />

			<x-dividers.form-divider class="py-4 font-bold col-span-6">Social</x-dividers.form-divider>

			<x-input
					label="Facebook Url"
					class="sm:col-span-2"
					placeholder="Facebook Url"
					wire:model="form.facebook_url" />
			<x-input
					label="Instagram Url"
					class="sm:col-span-2"
					placeholder="Instagram Url"
					wire:model="form.instagram_url" />
			<x-input
					class="sm:col-span-2"
					label="X Url"
					placeholder="X Url"
					wire:model="form.x_url" />
			<x-input
					class="sm:col-span-2"
					label="Snapchat Url"
					placeholder="Snapchat Url"
					wire:model="form.snapchat_url" />

			<x-input
					class="sm:col-span-2"
					label="Youtube Url"
					placeholder="Youtube Url"
					wire:model="form.youtube_url" />

			<x-datetime-picker
					label="Last Contact"
					class="sm:col-span-2"
					wire:model="form.last_contacted_at"
					:max="now()" />

			<x-dividers.form-divider class="py-4 font-bold col-span-6">Notes</x-dividers.form-divider>

			<x-textarea
					wire:model="form.physical_description"
					class="sm:col-span-3"
					label="Physical Description"
					placeholder="Physical Description" />

			<x-textarea
					wire:model="form.notes"
					class="sm:col-span-3"
					label="Notes"
					placeholder="Notes" />

		</div>
		<div>
			<div class="flex gap-8">
				<div class="min-h-24 grid grid-cols-5 gap-4 flex-1">
					@if($this->form->images)
						@foreach($this->form->images as $image)
							<img
									src="{{ $image->temporaryUrl() }}"
									class="h-24 w-24 object-cover rounded-md"
									alt="associate Image">
						@endforeach
					@endif
				</div>
				<div class="min-h-24 grid grid-cols-5 gap-4 flex-1">

				</div>

			</div>

			<div class="mt-5 grid grid-cols-1 gap-6 sm:grid-cols-6">
				<div class="sm:col-span-3">
					<x-form-elements.file-input
							multiple="true"
							wire-to="form.images"
							label="associate Images"
							placeholder="associate Images" />
					<p
							class="mt-0.5 text-xs text-gray-500"
							id="image-description">.JPG, .PNG, TIFF up to 10MB</p>
				</div>
				<div class="sm:col-span-3">
					<x-form-elements.file-input
							multiple="true"
							wire-to="form.images"
							label="associate Images"
							placeholder="associate Images" />
					<p
							class="mt-0.5 text-xs text-gray-500"
							id="image-description">.DOC, .PDF, .CSV up to 10MB</p>
				</div>
			</div>
		</div>
	</x-form-layouts.form-layout>
</div>
