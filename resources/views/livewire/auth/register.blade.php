<?php

	use App\Models\Tenant;
	use App\Models\User;
	use Illuminate\Auth\Events\Registered;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rules;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;

	new #[Layout('components.layouts.auth')] class extends Component {
		public string $name = '';
		public string $email = '';
		public string $password = '';
		public string $tenant_name = '';
		public string $password_confirmation = '';

		/**
		 * Handle an incoming registration request.
		 */
		public function register():void
		{
			$validated = $this->validate([
				'name' => ['required', 'string', 'max:255'],
				'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
				'tenant_name' => ['required', 'string', 'max:255', 'unique:'.Tenant::class],
				'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
			]);

			$validated['password'] = Hash::make($validated['password']);

			$newTenant = Tenant::create(['tenant_name' => $validated['tenant_name']]);

			$newUser = User::create([
				'name' => $validated['name'],
				'email' => $validated['email'],
				'password' => Hash::make($validated['password']),
				'tenant_id' => $newTenant->id, // Link user to tenant
			]);

			event(new Registered($newUser));

			Auth::login($newUser);

			$this->redirectIntended(route('dashboard', absolute: false), navigate: true);
		}
	}; ?>

<div class="flex flex-col gap-6">
	<x-auth-header
			:title="__('Create an account')"
			:description="__('Enter your details below to create your account')" />

	<!-- Session Status -->
	<x-auth-session-status
			class="text-center"
			:status="session('status')" />

	<form
			wire:submit="register"
			class="flex flex-col gap-6">
		<!-- Name -->
		<flux:input
				wire:model="name"
				:label="__('Name')"
				type="text"
				required
				autofocus
				autocomplete="name"
				:placeholder="__('Full name')"
		/>

		<!-- Email Address -->
		<flux:input
				wire:model="email"
				:label="__('Email address')"
				type="email"
				required
				autocomplete="email"
				placeholder="email@example.com"
		/>

		<flux:input
				wire:model="tenant_name"
				:label="__('Tenant Name')"
				type="text"
				required
				autofocus
				autocomplete="name"
				description="The name of your company or organization"
				:placeholder="__('Tenant Name')"
		/>

		<!-- Password -->
		<flux:input
				wire:model="password"
				:label="__('Password')"
				type="password"
				required
				autocomplete="new-password"
				:placeholder="__('Password')"
		/>

		<!-- Confirm Password -->
		<flux:input
				wire:model="password_confirmation"
				:label="__('Confirm password')"
				type="password"
				required
				autocomplete="new-password"
				:placeholder="__('Confirm password')"
		/>

		<div class="flex items-center justify-end">
			<flux:button
					type="submit"
					variant="primary"
					class="w-full">
				{{ __('Create account') }}
			</flux:button>
		</div>
	</form>

	<div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
		{{ __('Already have an account?') }}
		<flux:link
				:href="route('login')"
				wire:navigate>{{ __('Log in') }}</flux:link>
	</div>
</div>
