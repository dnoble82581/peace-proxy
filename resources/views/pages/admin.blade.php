<x-admin-layout>
	<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
	<div x-data="{tab: 'negotiations'}">
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
						x-show="tab === 'dashboard'"
						class="px-4 sm:px-6 lg:px-8">

					<div>
						<h3 class="text-base font-semibold text-gray-700 mb-4">Subscriptions</h3>
						<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-4">
							<div class="overflow-hidden rounded-lg bg-white shadow-sm">
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
									<x-buttons.small-primary
											type="button"
											class="bg-indigo-500">Edit Tenant
									</x-buttons.small-primary>
								</div>
							</div>
							<div class="overflow-hidden rounded-lg bg-white shadow-sm h-64">
								<div class="px-4 py-5 space-y-2.5 sm:p-6">
									<div class="flex items-center text-sm justify-between">
										<p class="text-gray-500">Subscription Name:</p>
										<span class="text-gray-900 font-semibold">{{ $subscriptionInfo['subscriptionName'] }}</span>
									</div>
									<div class="flex text-sm items-center justify-between">
										<p class="text-gray-500">Trial Began:</p>
										<span class="text-gray-900 font-semibold">{{ $subscriptionInfo['subscriptionTrialBegan'] }}</span>
									</div>
									<div class="flex text-sm items-center justify-between">
										<p class="text-gray-500">Trial Ends:</p>
										<span class="text-gray-900 font-semibold">{{ $subscriptionInfo['subscriptionTrialEnd'] }}</span>
									</div>
									<div class="flex text-sm items-center justify-between">
										<p class="text-gray-500">Next Invoice Amount:</p>
										<span class="text-gray-900 font-semibold">${{ $subscriptionInfo['nextInvoiceAmount'] }}</span>
									</div>
									<div class="flex text-sm items-center justify-between">
										<p class="text-sm text-gray-500">Next Invoice Due Date:</p>
										<span class="text-gray-900 font-semibold">{{ $subscriptionInfo['nextInvoiceDue'] }}</span>
									</div>


								</div>
								<div class="px-4 py-4 sm:px-6">
									<a
											href="{{route('subscriptions.billing.portal')}}"
											class="rounded bg-indigo-500 px-2 py-1 text-xs font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors ease-in-out">Edit
									                                                                                                                                                                                                                                       Subscription</a>
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
				<div
						x-show="tab === 'team'"
						class="px-4 sm:px-6 lg:px-8">
					<livewire:teams.show-team />
				</div>
				{{--				ToDO: Refactor this into a livewire component and make the rows sortable--}}
				<div
						x-show="tab === 'negotiations'"
						class="px-4 sm:px-6 lg:px-8">
					<div class="px-4 sm:px-6 lg:px-8">
						<div class="sm:flex sm:items-center">
							<div class="sm:flex-auto">
								<h1 class="text-base font-semibold text-gray-900">Negotiations</h1>
								<p class="mt-2 text-sm text-gray-700">A list of all the users in your account including
								                                      their name, title, email and role.</p>
							</div>
						</div>
						<div class="mt-8 flow-root">
							<div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
								<div class="inline-block min-w-full py-2 align-middle">
									<table class="min-w-full border-separate border-spacing-0">
										<thead>
										<tr>
											<th
													scope="col"
													class="sticky top-0 z-10 border-b border-gray-300 bg-white/75 py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 backdrop-blur-sm backdrop-filter sm:pl-6 lg:pl-8">
												Name
											</th>
											<th
													scope="col"
													class="sticky top-0 z-10 hidden border-b border-gray-300 bg-white/75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur-sm backdrop-filter sm:table-cell">
												Title
											</th>
											<th
													scope="col"
													class="sticky top-0 z-10 hidden border-b border-gray-300 bg-white/75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur-sm backdrop-filter lg:table-cell">
												Email
											</th>
											<th
													scope="col"
													class="sticky top-0 z-10 border-b border-gray-300 bg-white/75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur-sm backdrop-filter">
												Role
											</th>
											<th
													scope="col"
													class="sticky top-0 z-10 border-b border-gray-300 bg-white/75 py-3.5 pr-4 pl-3 backdrop-blur-sm backdrop-filter sm:pr-6 lg:pr-8">
												<span class="sr-only">Edit</span>
											</th>
										</tr>
										</thead>
										<tbody>
										<tr>
											<td class="border-b border-gray-200 py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6 lg:pl-8">
												Lindsay Walton
											</td>
											<td class="hidden border-b border-gray-200 px-3 py-4 text-sm whitespace-nowrap text-gray-500 sm:table-cell">
												Front-end Developer
											</td>
											<td class="hidden border-b border-gray-200 px-3 py-4 text-sm whitespace-nowrap text-gray-500 lg:table-cell">
												lindsay.walton@example.com
											</td>
											<td class="border-b border-gray-200 px-3 py-4 text-sm whitespace-nowrap text-gray-500">
												Member
											</td>
											<td class="relative border-b border-gray-200 py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-8 lg:pr-8">
												<a
														href="#"
														class="text-indigo-600 hover:text-indigo-900">Edit<span class="sr-only">, Lindsay Walton</span></a>
											</td>
										</tr>

										<!-- More people... -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</div>
</x-admin-layout>