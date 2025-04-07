<?php

	use App\Enums\UserPrivileges;
	use App\Livewire\Forms\UserForm;
	use App\Models\User;
	use Livewire\Features\SupportRedirects\Redirector;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;

	/**
	 * Anonymous Livewire Component for creating a new team member.
	 *
	 * This component handles the creation process, including form submissions,
	 * file uploads (e.g., avatar and application), and redirect actions.
	 */
	new class extends Component {
		use WithFileUploads;

		/**
		 * @var UserForm $form The form object to manage the creation of a new team member.
		 */
		public UserForm $form;

		public array $userPrivileges = [];

		/**
		 * Handles the form submission, creates a new team member,
		 * and redirects to the team management page.
		 *
		 * @return Redirector Returns a redirection to the '/team' route.
		 */
		public function submit():Redirector
		{
			// Create a new team member using the form data
			$this->form->create();

			// Redirect to the team management page
			return redirect(route('team'));
		}

		public function mount():void
		{
			$this->userPrivliges = UserPrivileges::cases();
		}

		/**
		 * Cancels the operation and redirects back to the team management page.
		 *
		 * @return Redirector Returns a redirection to the '/team' route.
		 */
		public function cancel():Redirector
		{
			return redirect(route('team'));
		}

		/**
		 * Retrieves the placeholder image for the user's avatar.
		 * If a new photo has been uploaded in the form, it returns its temporary URL.
		 * Otherwise, it returns a default placeholder image URL.
		 *
		 * @return string The placeholder or temporary URL for the avatar.
		 */
		public function getPhotoPlaceholder():string
		{
			if ($this->form->photo) {
				return $this->form->photo->temporaryUrl();
			}

			// Return default placeholder image
			return 'https://api.dicebear.com/9.x/shapes/svg?seed=Luis';
		}
	}

?>

<div>
	<!-- Form layout for creating a new team member -->
	<x-form-layouts.user-form submit="submit">
		<!-- Form header -->
		<x-slot:header>
			Create a new team member
		</x-slot:header>

		<!-- Form description -->
		<x-slot:description>
			Add a new team member to your team, allowing them to participate in active negotiations.
		</x-slot:description>

		<!-- Display validation errors -->
		<x-errors />

		<!-- Grid layout for form inputs -->
		<div class="grid grid-cols-6 gap-6">
			<!-- Input for the user's name -->
			<x-input
					id="name"
					label="Name"
					name="name"
					wire:model="form.name"
					placeholder="Full Name"
					class="col-span-6 sm:col-span-3" />

			<!-- Input for the user's email -->
			<x-input
					label="Email"
					name="email"
					wire:model="form.email"
					placeholder="Email"
					class="col-span-6 sm:col-span-3" />

			<!-- Input for the user's primary phone number -->
			<x-phone
					label="Primary Phone"
					placeholder="(555)-555-5555"
					wire:model="form.primary_phone"
					class="col-span-6 sm:col-span-2" />

			<!-- Input for the user's secondary phone number -->
			<x-phone
					label="Secondary Phone"
					placeholder="(555)-555-5555"
					wire:model="form.secondary_phone"
					class="col-span-6 sm:col-span-2" />

			<x-select
					label="User Privileges"
					name="privileges"
					wire:model="form.privileges"
					class="col-span-6 sm:col-span-2">
				@foreach(App\Enums\UserPrivileges::cases() as $privilege)
					<x-select.option
							label="{{ $privilege->name }}"
							value="{{ $privilege->value }}"
							description="{{ $privilege->metaData()['description']}}" />
				@endforeach
			</x-select>

			<x-select
					label="Status"
					wire:model="form.status"
					class="col-span-6 sm:col-span-2"
					:options="[
					['label' => 'Active', 'value' => 1],
					['label' => 'Inactive', 'value' => 0],
			]"
					option-label="label"
					option-value="value" />

			<x-password
					label="Password"
					name="password"
					wire:model="form.password"
					class="col-span-6 sm:col-span-2" />

			<x-password
					label="Password Confirmation"
					name="password_confirmation"
					wire:model="form.password_confirmation"
					class="col-span-6 sm:col-span-2" />


		</div>

		<!-- Avatar file input -->
		<div class="flex items-center mt-5 gap-8">
			<div>
				<!-- Avatar label -->
				<x-form-elements.input-label for="photo">Avatar</x-form-elements.input-label>
				<div class="flex flex-items-center">
					<div class="flex-shrink-0 h-10 w-10 mr-4">
						<!-- Avatar image or placeholder -->
						<img
								class="h-10 w-10 rounded-full"
								src="{{$this->getPhotoPlaceholder()}}"
								alt="">
					</div>
					<div class="flex items-center gap-3">
						<!-- Input for uploading avatar file -->
						<x-form-elements.file-input
								wire:model="form.photo"
								type="file"
								accept="image/*"
								class="mt-1" />

						<!-- Loading spinner when uploading photo -->
						<div
								wire:loading
								wire:target="form.photo">
							<x-svg-images.loading class="mr-4" />
						</div>
					</div>
				</div>
			</div>

			<!-- File input for application upload -->
			<div class="col-span-3">
				<label class="block text-sm leading-5 font-medium text-gray-700 mb-2">
					Application
				</label>
				<div class="flex flex-items-center">
					<div>
						<!-- Check if an application is uploaded and display the appropriate icon -->
						@if($this->form->application)
							<div class="flex-shrink-0 h-8 w-8 mr-4">
								<x-heroicons::outline.document-arrow-up class="h-8 w-8" />
							</div>
						@else
							<div class="flex-shrink-0 h-8 w-8 mr-4">
								<x-heroicons::outline.document class="h-8 w-8" />
							</div>
						@endif
					</div>
					<div>
						<div class="flex items-center gap-3">
							<!-- Input for uploading application file -->
							<x-form-elements.file-input
									wire-to="form.application"
									type="file"
									accept="application/pdf"
									class="mt-1" />
						</div>
						<!-- Loading spinner when uploading application -->
						<div
								wire:loading
								wire:target="form.application">
							<x-svg-images.loading class="mr-4" />
						</div>
					</div>
				</div>
				<!-- Display error for application field -->
				@error('application')
				<div class="text-sm text-red-500 mt-2">{{ $message }}</div>
				@enderror
			</div>
		</div>

		<!-- Action buttons -->
		<div class="mt-8 border-t border-gray-200 pt-5">
			<div class="flex justify-end">
				<!-- Loading spinner during submission -->
				<div
						wire:loading
						wire:target="submit">
					<x-svg-images.loading class="mr-4" />
				</div>

				<!-- Cancel and Save buttons -->
				<span class="inline-flex rounded-md shadow-sm gap-4">
                    <x-buttons.secondary-button
		                    wire:click="cancel()"
		                    :value="__('Cancel')" />
                    <x-buttons.primary-button :value="__('Save Team Member')" />
                </span>
			</div>
		</div>
	</x-form-layouts.user-form>
</div>