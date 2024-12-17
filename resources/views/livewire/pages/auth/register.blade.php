<?php

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $tenant_name = '';

    /**
     * Handle an incoming registration request.
     */
    public function register():void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'tenant_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $tenant = Tenant::create([
            'name' => $this->tenant_name,
        ]);

        event(new Registered($user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'tenant_id' => $tenant->id
        ])));

        Auth::login($user);

        $this->redirect(route('user.dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
	<form wire:submit="register">
		<!-- Name -->
		<div>
			<x-form-elements.input-label
					for="name"
					:value="__('Name')" />
			<x-form-elements.text-input
					wire:model="name"
					id="name"
					class="block mt-1 w-full"
					type="text"
					name="name"
					required
					autofocus
					autocomplete="name" />
			<x-form-elements.input-error
					:messages="$errors->get('name')"
					class="mt-2" />
		</div>

		<!-- Email Address -->
		<div class="mt-4">
			<x-form-elements.input-label
					for="email"
					:value="__('Email')" />
			<x-form-elements.text-input
					wire:model="email"
					id="email"
					class="block mt-1 w-full"
					type="email"
					name="email"
					required
					autocomplete="username" />
			<x-form-elements.input-error
					:messages="$errors->get('email')"
					class="mt-2" />
		</div>

		<!-- Email Address -->
		<div class="mt-4">
			<x-form-elements.input-label
					for="tenant_name"
					:value="__('Business/Agency Name')" />
			<x-form-elements.text-input
					wire:model="tenant_name"
					id="tenant_name"
					class="block mt-1 w-full"
					type="text"
					name="tenant_name"
					required
					autocomplete="tenant_name" />
			<x-form-elements.input-error
					:messages="$errors->get('email')"
					class="mt-2" />
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-form-elements.input-label
					for="password"
					:value="__('Password')" />

			<x-form-elements.text-input
					wire:model="password"
					id="password"
					class="block mt-1 w-full"
					type="password"
					name="password"
					required
					autocomplete="new-password" />

			<x-form-elements.input-error
					:messages="$errors->get('password')"
					class="mt-2" />
		</div>

		<!-- Confirm Password -->
		<div class="mt-4">
			<x-form-elements.input-label
					for="password_confirmation"
					:value="__('Confirm Password')" />

			<x-form-elements.text-input
					wire:model="password_confirmation"
					id="password_confirmation"
					class="block mt-1 w-full"
					type="password"
					name="password_confirmation"
					required
					autocomplete="new-password" />

			<x-form-elements.input-error
					:messages="$errors->get('password_confirmation')"
					class="mt-2" />
		</div>

		<div class="flex items-center justify-end mt-4">
			<a
					class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
					href="{{ route('login') }}"
					wire:navigate>
				{{ __('Already registered?') }}
			</a>

			<x-buttons.primary-button class="ms-4">
				{{ __('Register') }}
			</x-buttons.primary-button>
		</div>
	</form>
</div>
