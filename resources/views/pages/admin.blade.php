<x-admin-layout>
	<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
	<div x-data="{tab: 'dashboard'}">
		<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
		<div
				class="relative z-50 lg:hidden"
				role="dialog"
				aria-modal="true">
			<!--
			  Off-canvas menu backdrop, show/hide based on off-canvas menu state.

			  Entering: "transition-opacity ease-linear duration-300"
				From: "opacity-0"
				To: "opacity-100"
			  Leaving: "transition-opacity ease-linear duration-300"
				From: "opacity-100"
				To: "opacity-0"
			-->
			<div
					class="fixed inset-0 bg-gray-900/80"
					aria-hidden="true"></div>

			<div class="fixed inset-0 flex">
				<!--
				  Off-canvas menu, show/hide based on off-canvas menu state.

				  Entering: "transition ease-in-out duration-300 transform"
					From: "-translate-x-full"
					To: "translate-x-0"
				  Leaving: "transition ease-in-out duration-300 transform"
					From: "translate-x-0"
					To: "-translate-x-full"
				-->
				<div class="relative mr-16 flex w-full max-w-xs flex-1">
					<!--
					  Close button, show/hide based on off-canvas menu state.

					  Entering: "ease-in-out duration-300"
						From: "opacity-0"
						To: "opacity-100"
					  Leaving: "ease-in-out duration-300"
						From: "opacity-100"
						To: "opacity-0"
					-->
					<div class="absolute top-0 left-full flex w-16 justify-center pt-5">
						<button
								type="button"
								class="-m-2.5 p-2.5">
							<span class="sr-only">Close sidebar</span>
							<svg
									class="size-6 text-white"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M6 18 18 6M6 6l12 12" />
							</svg>
						</button>
					</div>

					<!-- Sidebar component, swap this element with another sidebar if you like -->
					@include('pages.partials.admin._responsive-sidebar')

				</div>
			</div>
		</div>

		<!-- Static sidebar for desktop -->
		<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
			<!-- Sidebar component, swap this element with another sidebar if you like -->
			@include('pages.partials.admin._static-sidebar')
		</div>

		<div class="lg:pl-72">
			@include('pages.partials.admin._admin-top-nav')

			<main
					class="py-10">
				<div
						x-show="tab === 'team'"
						class="px-4 sm:px-6 lg:px-8">
					<livewire:teams.show-team />
				</div>
				<div
						x-show="tab === 'dashboard'"
						class="px-4 sm:px-6 lg:px-8">

					<div>
						<h3 class="text-base font-semibold text-gray-700">Subscriptions</h3>
						<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
							<div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow-sm">
								<div class="px-4 py-5 sm:p-6 space-y-1">
									<h3>{{ $tenant->tenant_name }}</h3>
									<p class="text-sm text-gray-500">
										{{ $tenant->tenant_email }}
									</p>
									<p class="text-sm text-gray-500">
										{{ $tenant->getPhoneAttribute($tenant->primary_phone) }}
									</p>
									<p class="text-sm text-gray-500">
										{{ $tenant->address_line1 }}
									</p>
									<p class="text-sm text-gray-500">
										{{ $tenant->address_line2 }}
									</p>
									<p class="text-sm text-gray-500">
										<span>{{ $tenant->address_city }}</span>
										<span>{{ $tenant->address_state }}</span>
										<span>{{ $tenant->address_postal_code }}</span>
									</p>
									<p class="text-sm text-gray-500">
										{{ $tenant->address_country }}
									</p>
								</div>
								<div class="px-4 py-4 sm:px-6">
									<!-- Content goes here -->
									<!-- We use less vertical padding on card footers at all sizes than on headers or body sections -->
								</div>
							</div>
							<div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow-sm">
								
								<div class="px-4 py-4 sm:px-6">
									<!-- Content goes here -->
									<!-- We use less vertical padding on card footers at all sizes than on headers or body sections -->
								</div>
							</div>
						</div>
					</div>

					<div>
						<h3 class="text-base font-semibold text-gray-700">Last 30 days</h3>

						<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">

							<x-admin.small-team-data-card :tenant="$tenant" />
							<x-admin.small-negotiation-data-card :tenant="$tenant" />

							<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
								<dt>
									<div class="absolute rounded-md bg-indigo-500 p-3">
										<x-heroicons::outline.users class="text-white size-6" />
									</div>
									<p class="ml-16 truncate text-sm font-medium text-gray-500">Avg. Click Rate</p>
								</dt>
								<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
									<p class="text-2xl font-semibold text-gray-900">24.57%</p>
									<p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">
										<x-heroicons::outline.arrow-small-down class="text-red-400 mr-1.5 size-5" />
										<span class="sr-only"> Decreased by </span>
										3.2%
									</p>
									<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
										<div class="text-sm">
											<a
													href="#"
													class="font-medium text-indigo-600 hover:text-indigo-500">View
											                                                                  all<span class="sr-only"> Avg. Click Rate stats</span></a>
										</div>
									</div>
								</dd>
							</div>
						</dl>
					</div>

				</div>
			</main>
		</div>
	</div>
</x-admin-layout>