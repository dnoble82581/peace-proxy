<?php

	use App\Livewire\Forms\TenantForm;
	use App\Livewire\Forms\UserForm;
	use App\Models\Tenant;
	use App\Models\User;
	use App\Services\StripeService;
	use Illuminate\Auth\Events\Registered;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rules;
	use Livewire\Attributes\Layout;
	use Livewire\Volt\Component;
	use Livewire\WithFileUploads;

	new #[Layout('layouts.guest')] class extends Component {
		use WithFileUploads;

		public TenantForm $tenantForm;
		public UserForm $userForm;
		public Tenant $tenant;
		public User $user;

		/**
		 * Handle an incoming registration request.
		 */
		public function register():void
		{
			$this->tenant = $this->tenantForm->create();
			$this->user = $this->userForm->create($this->tenant);

			$stripeService = new StripeService;
			$stripeService->createStripeCustomer($this->tenant, $this->user);

			event(new Registered($this->user));

			Auth::login($this->user);

			$this->redirect(route('dashboard', absolute: false), navigate: true);
		}

		private function createStripeCustomer():void
		{
			$stripeService = new StripeService();
			$newCustomer = $stripeService->createStripeCustomer($this->tenant, $this->user);
		}

	}; ?>

<div>
	<x-errors />
	<form wire:submit="register">
		<div class="flex gap-5">
			<div class="flex-1 space-y-2 border border-gray-200 rounded-md p-4">
				<x-cards.card-headers.heading-description heading="User Information">
					Lorem ipsum dolor sit amet consectetur adipisicing
					elit quam corrupti consectetur.
				</x-cards.card-headers.heading-description>
				<!-- Name -->
				<x-input
						label="Name"
						wire:model="userForm.name"
						icon="user" />

				<!-- Email -->
				<x-input
						label="Email"
						wire:model="userForm.email"
						icon="envelope"
						suffix="@example.com" />

				<div class="flex gap-2">
					<!-- Primary Phone -->
					<x-phone
							label="Primary Phone"
							wire:model="userForm.primary_phone"
							icon="phone" />

					<x-phone
							label="Secondary Phone"
							wire:model="userForm.secondary_phone"
							icon="phone" />
				</div>

				<x-dividers.form-divider class=py-2>Avatar - Optional</x-dividers.form-divider>
				<!-- User Avatar -->

				<div class="flex gap-2 items-center">
					<div>
						@if($this->userForm->avatar)
							<img
									class="rounded-full size-14 object-cover"
									src="{{ $this->userForm->avatar->temporaryUrl() }}"
									alt="User Avatar">
						@else
							<x-svg-images.image-placeholder
									rounded="rounded-full"
									class="size-14" />
						@endif
					</div>
					<div>
						<x-form-elements.file-input
								class="ml-4"
								label="Upload Avatar"
								wire:model="userForm.avatar" />
					</div>
				</div>

				<x-dividers.form-divider class=py-2>Password Information</x-dividers.form-divider>

				<!-- Password -->
				<x-password
						label="Password"
						wire:model="userForm.password"
						autocomplete="new-password"
						name="password"
				/>

				<!-- Confirm Password -->
				<x-password
						label="Confirm Password"
						wire:model="userForm.password_confirmation"
						autocomplete="new-password"
						name="password_confirmation"
				/>


			</div>
			<div class="flex-1 space-y-2 border border-gray-200 rounded-md p-4">
				<x-cards.card-headers.heading-description heading="Tenant Information">
					Lorem ipsum dolor sit amet consectetur adipisicing
					elit quam corrupti consectetur.
				</x-cards.card-headers.heading-description>
				<x-input
						label="Business/Agency Name"
						wire:model="tenantForm.tenant_name"
						icon="building-office" />
				<x-input
						label="Business Email"
						wire:model="tenantForm.tenant_email"
						icon="envelope" />
				<div class="flex gap-2">
					<x-input
							label="Business Primary Phone"
							wire:model="tenantForm.primary_phone"
							icon="phone" />
					<x-input
							label="Business Secondary Phone"
							wire:model="tenantForm.secondary_phone"
							icon="phone" />
				</div>
				<x-input
						label="Business Address Line 1"
						wire:model="tenantForm.address_line1"
						icon="map-pin" />
				<x-input
						label="Business Address Line 2"
						wire:model="tenantForm.address_line2"
						icon="map-pin" />

				<x-input
						label="Business City"
						wire:model="tenantForm.address_city"
						icon="map-pin" />

				<div class="flex gap-2">

					<x-input
							label="Business State"
							wire:model="tenantForm.address_state"
							icon="map-pin" />
					<x-input
							label="Business Zip Code"
							wire:model="tenantForm.address_postal_code"
							icon="map-pin" />
					<x-input
							label="Address Country"
							wire:model="tenantForm.address_country"
							icon="map-pin" />
				</div>
			</div>
		</div>
		<div>

		</div>

		<!-- Passwords -->
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
{{--// Customer Contact Information
            $table->string('email')->nullable(); // Email Address
            $table->string('phone')->nullable(); // Phone Number

            // Customer Address Fields
            $table->string('address_line1')->nullable(); // Street Address (Line 1)
            $table->string('address_line2')->nullable(); // Street Address (Line 2)
            $table->string('address_city')->nullable(); // City
            $table->string('address_state')->nullable(); // State/Province
            $table->string('address_postal_code')->nullable(); // Postal/ZIP Code
            $table->string('address_country', 2)->nullable(); // ISO 3166-1 alpha-2 Country Code

            // Tax Information
            $table->string('tax_exempt')->nullable(); // Tax Exemption Status
            $table->string('tax_id')->nullable(); // Customer Tax ID

            // Additional Billing Information
            $table->text('extra_billing_information')->nullable(); // Extra Billing Information--}}