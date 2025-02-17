<?php

	use App\Events\SubjectUpdatedEvent;
	use App\Livewire\Forms\SubjectForm;
	use App\Models\Document;
	use Illuminate\Support\Carbon;
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\Storage;
	use App\Models\Room;
	use App\Models\Subject;
	use App\Models\SubjectImages;
	use LaravelIdea\Helper\App\Models\_IH_Room_C;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;
	use Livewire\Attributes\On;

	new class extends Component {
		use WithFileUploads;

		public SubjectForm $form;
		public Room $room;
		public Subject $subject;

		public $dob;

		public function mount($roomId):void
		{
			$this->room = $this->getRoom($roomId);
			$this->subject = $this->room->subject;
			$this->form->setForm($this->subject);
		}

		public function update():void
		{
			$this->form->update();
			$this->dispatch('subject-updated');
		}

		#[On('subject-updated')]
		public function redirectToRoom()
		{
			return $this->redirect(route('negotiation.room', $this->room->id), navigate: true);
		}

		private function getRoom($roomId):Room
		{
			return Room::findOrFail($roomId);
		}

//		ToDo: Fix this to auto update date of birth
		public function updatedDateOfBirth()
		{
			dd('here');
		}


		public function deleteDocument($documentId):void
		{
			$documentToDelete = Document::findOrFail($documentId);
			Storage::disk('s3')->delete('/documents/'.$this->subject->id.'/'.$documentToDelete->filename);
			$documentToDelete->delete();
		}

		public function removeImage($imageId):void
		{
			$image = SubjectImages::find($imageId);

			if (!$image) {
				$this->dispatch('error', 'Image not found');
				return;
			}
			$this->form->deleteImage($imageId);
		}
	}

?>
<div class="mt-5">
	<x-form-layouts.form-layout
			class="bg-white"
			submit="update">
		<x-slot:header>
			Edit Subject
		</x-slot:header>
		<x-slot:description>
			Non sint laboriosam ad perferendis soluta est quae consequatur et quae soluta qui exercitationem earum qui
			officiis consequatur sit dicta laboriosam.
		</x-slot:description>
		<x-slot:actions>
			<x-buttons.primary-button>
				Save
			</x-buttons.primary-button>
			<x-buttons.secondary-button wire:click="redirectToRoom">
				Cancel
			</x-buttons.secondary-button>
		</x-slot:actions>
		<x-dividers.form-divider class="font-bold">Basic Information</x-dividers.form-divider>
		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-input
					wire:model="form.name"
					label=" Subject Name"
					placeholder="Subject name" />
			<x-input
					wire:model="form.email"
					label="Email Address"
					placeholder="Subject Email" />
			<x-phone
					wire:model="form.phone"
					label="Phone Number"
					:mask="['(###) ###-####', '+# ### ###-####', '+## ## ####-####']" />

		</div>

		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-input
					wire:model="form.address"
					label="Address"
					placeholder="Subject Address" />
		</div>

		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-input
					wire:model="form.city"
					label="City"
					placeholder="Subject City" />
			<x-input
					wire:model="form.state"
					label="State"
					placeholder="Subject State" />
			<x-input
					wire:model="form.zip"
					label="Zip"
					placeholder="Subject Zip" />
		</div>

		<div class="flex flex-col sm:flex-row gap-4">
			<x-select
					wire:model="form.weapons"
					label="Believed to hae weapons?"
					placeholder="Weapons"
					:options="['Yes', 'No', 'Unknown']" />
			<x-textarea
					label="Weapons Details"
					placeholder="Weapons Description"
					wire:model="form.weapons_details" />
		</div>

		<x-dividers.form-divider class="font-bold">Details</x-dividers.form-divider>

		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-datetime-picker
					wire:model="form.date_of_birth"
					label="Date of Birth"
					placeholder="Appointment Date"
					without-timezone
					without-time="true"
					requires-confirmation
			/>
			<x-input
					wire:model="form.age"
					label="Age"
					placeholder="Subject Age" />

			<x-select
					wire:model="form.substance_abuse"
					label="Substance Abuse History"
					placeholder="Substance Abuse"
					:options="['Yes', 'No', 'Unknown']" />

		</div>
		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-select
					wire:model="form.mental_health_history"
					label="Mental Health History"
					placeholder="Mental Health History"
					:options="['Yes', 'No', 'Unknown']" />
			<x-select
					wire:model="form.race"
					label="Subject Race"
					placeholder="Subject Race"
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
					wire:model="form.gender"
					label="Subject Gender"
					:options="['Male', 'Female', 'Transgender', 'Unknown']" />
		</div>
		<div class="flex flex-col sm:flex-row items-center gap-4">

			<x-select
					wire:model="form.children"
					label="Children"
					:options="[1,2,3,4,5,6,7,8,9,10]" />
			<x-select
					wire:model="form.veteran"
					label="Veteran"
					:options="['Yes', 'No', 'Unknown']" />
			<x-select
					wire:model="form.highest_education"
					label="Highest Education"
					placeholder="Highest Education"
					:options="['Grade School', 'High School', 'College', 'Graduate', 'Unknown']" />
		</div>
		<x-dividers.form-divider class="py-4 font-bold">Social</x-dividers.form-divider>
		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-select
					wire:model="form.social_media"
					label="Search Social"
					placeholder="Select provider"
					multiselect
					:async-data="route('api.social-media.index')"
					:template="[
            'platform_name' => 'user-option',
        ]"
					option-label="platform_name"
					option-value="id"
					option-description="website_url"
			/>
		</div>
		<x-dividers.form-divider class="font-bold">Notes</x-dividers.form-divider>
		<div class="flex items-center gap-4">
			<x-textarea
					label="Physical Description"
					placeholder="Physical Description"
					wire:model="form.physical_description" />
			<x-textarea
					label="Notes"
					placeholder="Notes"
					wire:model="form.notes" />
		</div>
		<x-dividers.form-divider class="font-bold">Images</x-dividers.form-divider>

		<div class="flex flex-col sm:flex-row items-center gap-4 justify-between">
			<div class="flex-1">
				<div class="h-20 grid grid-cols-6 gap-4">
					@if ($this->form->images)
						@foreach ($this->form->images as $image)
							<div
									class="h-20 w-20 col-span-1"
									wire:key="{{ $loop->index }}">
								<img
										alt="Image"
										src="{{ $image->temporaryUrl() }}"
										class="object-fill">
							</div>
						@endforeach
					@endif
					@if($this->subject->images)
						@foreach($this->subject->images as $image)
							<div
									class="relative col-span-1"
									wire:key="{{ $image->image }}">
								<img
										src="{{ $this->subject->imageUrl($image->image) }}"
										class="w-20 h-20 rounded"
										alt="Image">
								<button
										type="button"
										class="absolute bottom-1 right-3 text-white hover:text-rose-400"
										wire:click="removeImage({{ $image->id }})">
									<x-heroicons::outline.trash
											class="w-4 h-4 " />
								</button>
							</div>
						@endforeach
					@endif
				</div>
				<div class="">
					<x-form-elements.file-input
							multiple
							wire:model="form.images"
							class=" mt-4" />
					<p
							class="mt-0.5 text-xs text-gray-500"
							id="image-description">PNG, JPG, GIF up to 10MB</p>
				</div>
			</div>
			<div class="flex-1">
				<div class="h-20 grid grid-cols-6 gap-4">
					@foreach($this->subject->documents as $document)
						<div>
							<x-heroicons::outline.paper-clip class="w-8 h-8" />
							<p class="truncate text-gray-600 text-sm">{{ $document->filename }}</p>
							<button
									type="button"
									wire:click="deleteDocument({{ $document->id }})">
								<x-heroicons::outline.trash class="w-4 h-4 text-rose-500" />
							</button>
						</div>
					@endforeach
				</div>
				<div class="">
					<x-form-elements.file-input
							wire-to="form.documentsToUpload"
							type="file"
							multiple
							accept="application/pdf"
							class="mt-4" />
					<p
							class="mt-0.5 text-xs text-gray-500"
							id="image-description">.DOC, .PDF, CSV up to 10MB</p>
				</div>
			</div>
		</div>
	</x-form-layouts.form-layout>
</div>