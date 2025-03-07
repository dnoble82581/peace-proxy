<?php

	use App\Events\UserLoggedInEvent;
	use App\Livewire\Forms\LoginForm;
	use Illuminate\Support\Facades\Session;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;


	new #[Layout('layouts.guest')] class extends Component {
		public LoginForm $form;

		/**
		 * Handle an incoming authentication request.
		 */
		public function login():void
		{
			$this->validate();

			$this->form->authenticate();
			$user = auth()->user();
			$user->update(['role' => '']);

			Session::regenerate();

			$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
		}
	}; ?>

<div>
	<!-- Session Status -->
	<x-sessions.auth-session-status
			class="mb-4"
			:status="session('status')" />

	<form wire:submit="login">
		<!-- Email Address -->
		<div>
			<x-input
					label="Email"
					wire:model="form.email" />
		</div>

		<!-- Password -->
		<div class="mt-4">
			<x-password
					label="Password"
					wire:model="form.password" />
		</div>

		<!-- Remember Me -->
		<div class="block mt-4">
			<label
					for="remember"
					class="inline-flex items-center">
				<input
						wire:model="form.remember"
						id="remember"
						type="checkbox"
						class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
						name="remember">
				<span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
			</label>
		</div>

		<div class="flex items-center justify-end mt-4">
			@if (Route::has('password.request'))
				<a
						class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
						href="{{ route('password.request') }}"
						wire:navigate>
					{{ __('Forgot your password?') }}
				</a>
				<a
						class="underline text-sm text-gray-600 ml-5 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
						href="{{ route('register') }}"
						wire:navigate>
					{{ __('Need an Account?') }}
				</a>
			@endif

			<x-buttons.primary-button class="ms-3">
				{{ __('Log in') }}
			</x-buttons.primary-button>
		</div>
	</form>
</div>
