<?php

	use Illuminate\Auth\Events\Lockout;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\RateLimiter;
	use Illuminate\Support\Facades\Route;
	use Illuminate\Support\Facades\Session;
	use Illuminate\Support\Str;
	use Illuminate\Validation\ValidationException;
	use Livewire\Attributes\Layout;
	use Livewire\Attributes\Validate;
	use Livewire\Volt\Component;

	new #[Layout('components.layouts.auth')] class extends Component {
		#[Validate('required|string|email')]
		public string $email = '';

		#[Validate('required|string')]
		public string $password = '';

		public bool $remember = false;

		/**
		 * Handle an incoming authentication request.
		 */
		public function login():void
		{
			$this->validate();

			$this->ensureIsNotRateLimited();

			if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
				RateLimiter::hit($this->throttleKey());

				throw ValidationException::withMessages([
					'email' => __('auth.failed'),
				]);
			}

			RateLimiter::clear($this->throttleKey());
			Session::regenerate();

			$this->redirectIntended(default: route('dashboard', ['tenant' => auth()->user()->tenant], absolute: false),
				navigate: true);
		}

		/**
		 * Ensure the authentication request is not rate limited.
		 */
		protected function ensureIsNotRateLimited():void
		{
			if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
				return;
			}

			event(new Lockout(request()));

			$seconds = RateLimiter::availableIn($this->throttleKey());

			throw ValidationException::withMessages([
				'email' => __('auth.throttle', [
					'seconds' => $seconds,
					'minutes' => ceil($seconds / 60),
				]),
			]);
		}

		/**
		 * Get the authentication rate limiting throttle key.
		 */
		protected function throttleKey():string
		{
			return Str::transliterate(Str::lower($this->email).'|'.request()->ip());
		}
	}; ?>

<div class="flex flex-col items-center justify-center">

	<div>
		<div class="text-center">
			<h2 class="text-2xl">Sign into your account</h2>
		</div>
	</div>
	<div class="mt-6 dark:bg-primary-600 bg-primary-100 min-w-xl p-8 rounded-md">
		<div class="text-center mb-4">
			@if(session()->has('error'))
				<flux:error message="{{ session('error') }}" />
			@endif
		</div>
		<form wire:submit="login">
			@csrf
			<div class="space-y-6">
				<flux:field>
					<flux:input
							icon="user"
							type="email"
							label="Email Address"
							wire:model="email" />
				</flux:field>
				<flux:field>
					<flux:input
							icon="lock-closed"
							type="password"
							label="Password"
							wire:model="password" />
				</flux:field>
				<div class="flex items-center justify-between">
					<flux:field>
						<flux:checkbox
								label="Remember Me"
								wire:model="rememberMe" />
					</flux:field>
					<flux:field>
						<flux:button-or-link
								href="/forgot-password"
								class="hover:text-primary-100 transition-colors ease-in-out">Forgot your password?
						</flux:button-or-link>
					</flux:field>
				</div>
				<flux:field>
					<button
							type="submit"
							class="w-full bg-accent-500 p-2 rounded-lg hover:bg-accent-600 transition-colors ease-in-out">
						Sign In
					</button>
				</flux:field>
			</div>
			<div class="mt-5">
				<flux:separator text="or sign in with" />
				<div class="flex items-center justify-around mt-4">
					<button
							type="button"
							class="dark:bg-primary-400 bg-primary-100 px-2 py-1 rounded">Google
					</button>
					<button
							type="button"
							class="dark:bg-primary-400 bg-primary-100 px-2 py-1 rounded">Facebook
					</button>
					<button
							type="button"
							class="dark:bg-primary-400 bg-primary-100 px-2 py-1 rounded">GitHub
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
