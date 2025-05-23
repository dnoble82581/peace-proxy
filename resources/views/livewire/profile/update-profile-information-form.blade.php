<?php

	use App\Models\User;
	use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Validation\Rule;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;

	new class extends Component {
		use WithFileUploads;

		public string $name = '';
		public string $email = '';
		public ?string $primary_phone;
		public ?string $secondary_phone;
		public $avatar = '';
		public User $user;

		/**
		 * Mount the component.
		 */
		public function mount():void
		{
			$this->user = Auth::user();
			$this->name = Auth::user()->name;
			$this->email = Auth::user()->email;
			$this->primary_phone = Auth::user()->primary_phone ?? '';
			$this->secondary_phone = Auth::user()->secondary_phone ?? '';
			$this->avatar;
		}

		/**
		 * Update the profile information for the currently authenticated user.
		 */
		public function updateProfileInformation():void
		{
			$user = Auth::user();

			$validated = $this->validate([
				'name' => ['required', 'string', 'max:255'],
				'primary_phone' => ['nullable'],
				'avatar' => ['image', 'mimes:jpg'],
				'secondary_phone' => ['nullable'],
				'email' => [
					'required', 'string', 'lowercase', 'email', 'max:255',
					Rule::unique(User::class)->ignore($user->id)
				],
			]);

			$user->fill($validated);

			if ($user->isDirty('email')) {
				$user->email_verified_at = null;
			}

			if ($this->avatar) {
				$this->deleteExistingAvatar();
				Auth::user()->avatar = $this->saveUserAvatar();
			}

			$user->save();

			$this->dispatch('profile-updated', name: $user->name);
		}

		private function deleteExistingAvatar():void
		{
			if ($this->avatar) {
				if (Storage::disk('s3-public')->exists(Auth::user()->avatar)) {
					Storage::disk('s3-public')->delete(Auth::user()->avatar);
				}
			}
		}

		public function saveUserAvatar():string
		{
			return $this->avatar->store(Auth::user()->tenant->name.'/avatars/'.Auth::user()->id, 's3-public');
		}

		/**
		 * Send an email verification notification to the current user.
		 */
		public function sendVerification():void
		{
			$user = Auth::user();

			if ($user->hasVerifiedEmail()) {
				$this->redirectIntended(default: route('dashboard', absolute: false));

				return;
			}

			$user->sendEmailVerificationNotification();

			Session::flash('status', 'verification-link-sent');
		}
	}; ?>

<section>
	<header>
		<h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
			{{ __('Profile Information') }}
		</h2>

		<p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
			{{ __("Update your account's profile information and email address.") }}
		</p>
	</header>

	<form
			wire:submit="updateProfileInformation"
			class="mt-6 space-y-6">
		<div>
			<x-form-elements.input-label for="photo">Avatar</x-form-elements.input-label>
			<div class="flex items-center">
				<div class="flex-shrink-0 h-10 w-10 mr-4">
					@if($this->avatar)
						<img
								class="h-10 w-10 rounded-full"
								src="{{$this->avatar->temporaryUrl()}}"
								alt="">
					@else
						<img
								class="h-10 w-10 rounded-full"
								src="{{Auth::user()->avatarUrl()}}"
								alt="">
					@endif

				</div>
				<div class="flex items-center gap-3">
					<x-form-elements.file-input
							wire-to="avatar"
							type="file"
							accept="image/*"
							class="mt-1" />

				</div>
			</div>
		</div>
		<div>
			<x-form-elements.input-label
					for="name"
					:value="__('Name')" />
			<x-form-elements.text-input
					wire:model="name"
					id="name"
					name="name"
					type="text"
					class="mt-1 block w-full"
					required
					autofocus
					autocomplete="name" />
			<x-form-elements.input-error
					class="mt-2"
					:messages="$errors->get('name')" />
		</div>

		<div>
			<x-form-elements.input-label
					for="email"
					:value="__('Email')" />
			<x-form-elements.text-input
					wire:model="email"
					id="email"
					name="email"
					type="email"
					class="mt-1 block w-full"
					required
					autocomplete="username" />
			<x-form-elements.input-error
					class="mt-2"
					:messages="$errors->get('email')" />

			@if (auth()->user() instanceof MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
				<div>
					<p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
						{{ __('Your email address is unverified.') }}

						<button
								wire:click.prevent="sendVerification"
								class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
							{{ __('Click here to re-send the verification email.') }}
						</button>
					</p>

					@if (session('status') === 'verification-link-sent')
						<p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
							{{ __('A new verification link has been sent to your email address.') }}
						</p>
					@endif
				</div>
			@endif
		</div>
		<div>
			<x-phone
					wire:model="primary_phone"
					label="Primary Phone"
					autocomplete="phone" />
		</div>
		<div>
			<x-phone
					wire:model="secondary_phone"
					autocomplete="phone"
					label="Secondary Phone" />
		</div>

		<div class="flex items-center gap-4">
			<x-buttons.primary-button>{{ __('Save') }}</x-buttons.primary-button>

			<x-action-messages.action-message
					class="me-3"
					on="profile-updated">
				{{ __('Saved.') }}
			</x-action-messages.action-message>
		</div>
	</form>
</section>
