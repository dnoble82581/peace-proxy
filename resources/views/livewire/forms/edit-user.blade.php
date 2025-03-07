<?php

	use App\Enums\UserPrivileges;
	use App\Livewire\Forms\UserForm;
	use App\Models\User;
	use LaravelIdea\Helper\App\Models\_IH_User_C;
	use Livewire\Features\SupportRedirects\Redirector;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;

	/**
	 * This class manages the update form for a Team Member.
	 * It includes file upload capabilities and binds the form data to the UserForm model.
	 */
	new class extends Component {
		use WithFileUploads;

		/**
		 * @var UserForm Bound form object containing user data to be updated.
		 */
		public UserForm $form;

		/**
		 * @var User The team member being updated.
		 */
		public User $user;

		public array $userPrivileges = [];

		/**
		 * @var array List of available roles with labels and values.
		 */
		public array $roles = [
			['name' => 'Admin', 'value' => 'admin'],
			['name' => 'User', 'value' => 'user'],
		];

		/**
		 * @var array List of available statuses with labels and values.
		 */
		public array $statuses = [
			['name' => 'Active', 'value' => 1],
			['name' => 'Inactive', 'value' => 0],
		];

		/**
		 * Mount method initializes the user data and pre-populates the form
		 * when editing an existing user.
		 *
		 * @param  User  $user  The specific user being edited.
		 *
		 * @return void
		 */
		public function mount($user):void
		{
			if ($user) {
				$this->user = $user;
				$this->form->setForm($this->user); // Initializes the form with user data.
			}
			$this->userPrivileges = UserPrivileges::cases();

		}

		/**
		 * Handles the form submission, updates the team member,
		 * and redirects to the team management page.
		 *
		 * @return Redirector Redirects to the '/team' route upon successful action.
		 */
		public function submit():Redirector
		{
			$this->form->update(); // Updates the user data.
			return redirect(route('team')); // Redirects back to the team list.
		}

		/**
		 * Handles the cancel action and redirects the user
		 * back to the team management page.
		 *
		 * @return Redirector Redirects to the '/team' route.
		 */
		public function cancel():Redirector
		{
			return redirect(route('team'));
		}

		/**
		 * Generates and returns the URL for user avatar.
		 * Prefers the photo from the form if any, otherwise falls back to the user's default avatar.
		 *
		 * @return string URL of the avatar placeholder or uploaded image.
		 */
		public function getPhotoPlaceholder():string
		{
			if ($this->form->photo) {
				return $this->form->photo->temporaryUrl();
			}

			return $this->user->avatar?: $this->user->avatarUrl();
		}
	}
?>

<div>
	<!-- Form to update a team member -->
	<x-form-layouts.form-layout submit="submit">
		<x-slot:header>
			Update Team Member
		</x-slot:header>
		<x-slot:description>
			Update the details of a team member.
		</x-slot:description>

		{{-- Display validation errors from the backend --}}
		<x-errors />

		<!-- Form grid for user input -->
		<div class="grid grid-cols-6 gap-6">
			{{-- Input for the user's name --}}
			<x-input
					id="name"
					label="Name"
					name="name"
					wire:model="form.name"
					placeholder="Full Name"
					class="col-span-6 sm:col-span-3" />

			{{-- Input for the user's email address --}}
			<x-input
					label="Email"
					name="email"
					wire:model="form.email"
					placeholder="Email"
					class="col-span-6 sm:col-span-3" />

			{{-- Input for the user's primary phone number --}}
			<x-phone
					label="Primary Phone"
					placeholder="(555)-555-5555"
					wire:model="form.primary_phone"
					class="col-span-6 sm:col-span-2" />

			{{-- Input for the user's secondary phone number --}}
			<x-phone
					label="Secondary Phone"
					placeholder="(555)-555-5555"
					wire:model="form.secondary_phone"
					class="col-span-6 sm:col-span-2" />

			{{-- Dropdown for the user's status (Active/Inactive) --}}
			<x-select
					label="Status"
					wire:model="form.status"
					class="col-span-6 sm:col-span-2"
					:options="$statuses"
					option-label="name"
					option-value="value" />

			{{-- Input for the user's title --}}
			<x-select
					label="User Privileges"
					name="privileges"
					wire:model="form.privileges"
					class="col-span-6 sm:col-span-2">
				@foreach($this->userPrivileges as $privilege)
					<x-select.option
							label="{{ $privilege->name }}"
							value="{{ $privilege->value }}"
							description="{{ $privilege->metaData()['description']}}" />
				@endforeach
			</x-select>

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

		{{-- File input for avatar upload with preview --}}
		<div class="flex items-center gap-8 mt-5">
			<div>
				<x-form-elements.input-label for="photo">Avatar</x-form-elements.input-label>
				<div class="flex items-center">
					<div class="flex-shrink-0 h-10 w-10 mr-4">
						@if($this->form->photo)
							<img
									class="h-10 w-10 rounded-full"
									src="{{$this->form->photo->temporaryUrl()}}"
									alt="">
						@else
							<img
									class="h-10 w-10 rounded-full"
									src="{{ $user->avatarUrl() }}"
									alt="">
						@endif

					</div>
					<div class="flex items-center gap-3">
						{{-- File input for photo upload --}}
						<x-form-elements.file-input
								wire-to="form.photo"
								type="file"
								accept="image/*"
								class="mt-1" />

						{{-- Loading animation during photo upload --}}
						<div
								wire:loading
								wire:target="form.photo">
							<x-svg-images.loading class="mr-4" />
						</div>
					</div>
				</div>
			</div>

			{{-- File input for application upload --}}
			<div>
				<label class="block text-sm leading-5 font-medium text-gray-700 mb-2">
					Application
				</label>
				<div class="flex items-center">
					{{-- Icon representing the uploaded application --}}
					<div>
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
					<div class="flex items-center gap-3">
						{{-- File input for application upload --}}
						<x-form-elements.file-input
								wire-to="form.application"
								multiple
								type="file"
								accept="application/pdf"
								class="mt-1" />

						{{-- Loading animation during application upload --}}
						<div
								wire:loading
								wire:target="form.application">
							<x-svg-images.loading class="mr-4" />
						</div>
					</div>
				</div>

				{{-- Display validation error for the application field --}}
				@error('application')
				<div class="text-sm text-red-500 mt-2">{{ $message }}</div>
				@enderror
			</div>
		</div>

		{{-- Submit and Cancel Buttons --}}
		<div class="mt-8 border-t border-gray-200 pt-5">
			<div class="flex justify-end">
				{{-- Loading spinner during submission --}}
				<div
						wire:loading
						wire:target="submit">
					<x-svg-images.loading class="mr-4" />
				</div>
				<x-slot name="actions">
					{{-- Cancel action --}}
					<x-buttons.secondary-button wire:click="cancel">Cancel</x-buttons.secondary-button>

					{{-- Submit button --}}
					<x-buttons.primary-button>Update Team Member</x-buttons.primary-button>
				</x-slot>
			</div>
		</div>
	</x-form-layouts.form-layout>
</div>