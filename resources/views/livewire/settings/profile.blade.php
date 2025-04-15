<?php

	use App\Models\User;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Validation\Rule;
	use Livewire\Volt\Component;

	new class extends Component {
		public string $name = '';
		public string $email = '';
		public string $primary_phone = '';
		public string $secondary_phone = '';
		public string $address_line1 = '';
		public string $address_line2 = '';
		public string $city = '';
		public string $state = '';
		public string $postal_code;
		public string $country = '';
		public string $role = '';

		/**
		 * Mount the component.
		 */
		public function mount():void
		{
			$this->getData();
		}

		private function getData()
		{
			$this->name = Auth::user()->name;
			$this->email = Auth::user()->email;
			$this->primary_phone = Auth::user()->primary_phone ?? '';
			$this->secondary_phone = Auth::user()->secondary_phone ?? '';
			$this->address_line1 = Auth::user()->address_line1 ?? '';
			$this->address_line2 = Auth::user()->address_line2 ?? '';
			$this->city = Auth::user()->city ?? '';
			$this->state = Auth::user()->state ?? '';
			$this->postal_code = Auth::user()->postal_code ?? '';
			$this->country = Auth::user()->country ?? '';
			$this->role = Auth::user()->role ?? '';

		}

		/**
		 * Update the profile information for the currently authenticated user.
		 */
		public function updateProfileInformation():void
		{
			$user = Auth::user();

			$validated = $this->validate([
				'name' => ['required', 'string', 'max:255'],

				'email' => [
					'required',
					'string',
					'lowercase',
					'email',
					'max:255',
					Rule::unique(User::class)->ignore($user->id)
				],
				'primary_phone' => ['nullable'],
				'secondary_phone' => ['nullable'],
				'address_line1' => ['nullable', 'string', 'max:100'],
				'address_line2' => ['nullable', 'string', 'max:100'],
				'city' => ['nullable', 'string', 'max:100'],
				'state' => ['nullable', 'string'],
				'postal_code' => ['nullable', 'string'],
				'country' => ['nullable', 'string', 'max:2'],
				'role' => ['string'],
			]);

			$user->fill($validated);

			if ($user->isDirty('email')) {
				$user->email_verified_at = null;
			}

			$user->save();

			$this->dispatch('profile-updated', name: $user->name);
		}

		/**
		 * Send an email verification notification to the current user.
		 */
		public function resendVerificationNotification():void
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

<section class="w-full">
	@include('partials.settings-heading')

	<x-settings.layout
			:heading="__('Profile')"
			:subheading="__('Update your name and email address')">
		<form
				wire:submit="updateProfileInformation"
				class="my-6 w-full space-y-6">
			<flux:input
					wire:model="name"
					:label="__('Name')"
					type="text"
					required
					autofocus
					autocomplete="name" />

			<flux:input
					wire:model="primary_phone"
					mask="(999) 999-9999"
					:label="__('Phone')"
					type="text"
					autocomplete="phone" />

			<flux:input
					wire:model="secondary_phone"
					mask="(999) 999-9999"
					:label="__('Secondary Phone')"
					type="text"
					autocomplete="phone" />

			<div class="grid grid-cols-2 gap-4">
				<flux:input
						wire:model="address_line1"
						:label="__('Address Line 1')"
						type="text"
						autocomplete="address-line1" />

				<flux:input
						wire:model="address_line2"
						:label="__('Address Line 2')"
						type="text"
						autocomplete="address-line2" />
			</div>
			<div class="grid grid-cols-2 gap-4">
				<flux:input
						wire:model="city"
						:label="__('City')"
						type="text"
						autocomplete="city" />

				<flux:input
						wire:model="state"
						:label="__('State')"
						type="text"
						autocomplete="state" />

				<flux:input
						wire:model="postal_code"
						:label="__('Postal Code')"
						type="text"
						autocomplete="postal-code" />
				<flux:input
						wire:model="country"
						:label="__('Country')"
						type="text"
						autocomplete="country" />
			</div>

			<flux:select
					wire:model="role"
					:label="__('Role')"
					placeholder="Select role...">
				<flux:select.option>
					<div class="flex items-center gap-2">
						<flux:icon.shield-check
								variant="mini"
								class="text-zinc-400" />
						User
					</div>
				</flux:select.option>

				<flux:select.option>
					<div class="flex items-center gap-2">
						<flux:icon.key
								variant="mini"
								class="text-zinc-400" />
						Administrator
					</div>
				</flux:select.option>

				<flux:select.option>
					<div class="flex items-center gap-2">
						<flux:icon.user
								variant="mini"
								class="text-zinc-400" />
						Member
					</div>
				</flux:select.option>

				<flux:select.option value="viewer">
					<div class="flex items-center gap-2">
						<flux:icon.eye
								variant="mini"
								class="text-zinc-400" />
						Viewer
					</div>
				</flux:select.option>
			</flux:select>


			<div>
				<flux:input
						wire:model="email"
						:label="__('Email')"
						type="email"
						required
						autocomplete="email" />

				@if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
					<div>
						<flux:text class="mt-4">
							{{ __('Your email address is unverified.') }}

							<flux:link
									class="text-sm cursor-pointer"
									wire:click.prevent="resendVerificationNotification">
								{{ __('Click here to re-send the verification email.') }}
							</flux:link>
						</flux:text>

						@if (session('status') === 'verification-link-sent')
							<flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
								{{ __('A new verification link has been sent to your email address.') }}
							</flux:text>
						@endif
					</div>
				@endif


			</div>

			<div class="flex items-center gap-4">
				<div class="flex items-center justify-end">
					<flux:button
							variant="primary"
							type="submit"
							class="w-full">{{ __('Save') }}</flux:button>
				</div>

				<x-action-message
						class="me-3"
						on="profile-updated">
					{{ __('Saved.') }}
				</x-action-message>
			</div>
		</form>

		<livewire:settings.delete-user-form />
	</x-settings.layout>
</section>
