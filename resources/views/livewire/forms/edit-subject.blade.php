<?php

use App\Livewire\Forms\SubjectForm;
use App\Models\Room;
use App\Models\Subject;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;

    public SubjectForm $form;
    public Room $room;
    public Subject $subject;


    public function mount($roomId)
    {
        $this->room = $this->getRoom($roomId);
        $this->subject = $this->room->subject;
        $this->form->setForm($this->subject);

    }

    private function getRoom($roomId)
    {
        return Room::findOrFail($roomId);
    }

    public function update()
    {
        $this->form->update();
        return redirect(route('negotiation.room', $this->room->id));
    }
}

?>
<div>
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
			<x-buttons.secondary-button>
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

		<x-dividers.form-divider class="font-bold">Details</x-dividers.form-divider>
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

		<div class="flex flex-col sm:flex-row items-center gap-4">
			<x-datetime-picker
					label="Date of Birth"
					wire:model="form.date_of_birth"
					:max="now()"
					without-time="true" />
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
			<x-input
					label="Facebook Url"
					placeholder="Facebook Url"
					wire:model="form.facebook_url" />
			<x-input
					label="Instagram Url"
					placeholder="Instagram Url"
					wire:model="form.instagram_url" />
			<x-input
					label="X Url"
					placeholder="X Url"
					wire:model="form.x_url" />
			<x-input
					label="Snapchat Url"
					placeholder="Snapchat Url"
					wire:model="form.snapchat_url" />
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
		<div>
			<div class="h-20 flex gap-2">
				@if ($this->form->images)
					@foreach ($this->form->images as $image)
						<div class="h-20 w-20">
							<img
									alt="Image"
									src="{{ $image->temporaryUrl() }}"
									class="object-fill">
						</div>
					@endforeach
				@endif
				@if($this->subject->images)
					@foreach($this->subject->images as $image)
						<div class="relative">
							<img
									src="{{ $this->subject->imageUrl($image->image) }}"
									class="w-20 h-20 rounded"
									alt="Image">
							<button
									class="absolute bottom-1 right-1 text-white hover:text-rose-400"
									wire:click="removeImage({{ $image->id }})">
								<x-heroicons::outline.trash
										class="w-4 h-4 " />
							</button>
						</div>
					@endforeach
				@endif
			</div>
			<div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
				<div class="text-center">
					<svg
							class="mx-auto size-12 text-gray-300"
							viewBox="0 0 24 24"
							fill="currentColor"
							aria-hidden="true"
							data-slot="icon">
						<path
								fill-rule="evenodd"
								d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
								clip-rule="evenodd" />
					</svg>
					<div class="mt-4 flex text-sm/6 text-gray-600">
						<label
								for="file-upload"
								class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
							<span>Upload Images</span>
							<input
									id="file-upload"
									wire:model="form.images"
									name="file-upload"
									type="file"
									multiple
									class="sr-only">
						</label>
						<p class="pl-1">or drag and drop</p>
					</div>
					<p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
				</div>
			</div>
		</div>
	</x-form-layouts.form-layout>
</div>