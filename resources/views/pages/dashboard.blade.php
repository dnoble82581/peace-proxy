<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Dashboard') }}
			<p class="mt-2 text-sm text-gray-500">A list of all the users in your account including their name,
			                                      title, email and role.</p>
		</h2>
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<x-links.primary-solid-link
					class="mb-3"
					href="{{ route('create.negotiation') }}">Create Negotiation
			</x-links.primary-solid-link>
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900 dark:text-gray-100">
					<div class="border-b border-gray-200 pb-5">
						<h3 class="text-base font-semibold text-gray-900 dark:text-slate-300">Active Negotiations</h3>
					</div>
					<livewire:negotiations.negotiation-list />
				</div>
			</div>
			@if(! $negotiations->count())
				<div class="mt-4 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
					<!-- Be sure to use this with a layout container that is full-width on mobile -->
					<div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
						<div class="px-4 py-5 sm:p-6">
							<div class="text-center mb-6">
								<h1 class="text-2xl font-bold text-gray-800">Welcome to Peace Proxy!</h1>
							</div>
							<p class="mb-3 text-gray-500 dark:text-gray-400">
								We extend our deepest gratitude to hostage negotiators and police officers for their
								unwavering courage, skill, and dedication in the face of unimaginable pressure. Your
								tireless efforts to protect lives, de-escalate crises, and bring peace to chaotic
								situations embody the very best of humanity. Through your calm professionalism and
								selfless service, you not only safeguard communities but also offer hope and resolution
								where it’s needed most—thank you for all that you do.
							</p>
						</div>
						<div class="grid grid-cols-1 gap-6 sm:grid-cols-3 p-6 lg:grid-cols-4">
							<div class="divide-y divide-gray-200 overflow-hidden bg-slate-100 rounded-lg shadow-lg col-span-2">
								<div class="px-4 py-5 sm:px-6">
									<h3 class="text-base font-semibold text-gray-900">Getting Started!</h3>
									<p class="mt-1 text-sm text-gray-500">Dive into Peace Proxy with
									                                      confidence—exploring its features will unlock
									                                      powerful tools to streamline your experience
									                                      and connect with your team! Below you will
									                                      find ways to get started.</p>
								</div>
								<div class="px-4 py-5 sm:p-6">
									<h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Where To
									                                                                     Begin</h2>
									<ul class="space-y-4 text-gray-500 list-disc list-inside dark:text-gray-400">
										<li>
											Add your details to personalize your Peace Proxy experience
											<ul class="ps-5 mt-2 space-y-1 list-decimal list-inside">
												<li>In the top right of your screen you will see your name.</li>
												<li>Click on it and then click profile to edit your details.
												</li>
											</ul>
										</li>
										<li>
											Create your team by clicking on My Team in the Top Navigation Bar
											<ul class="ps-5 mt-2 space-y-1 list-decimal list-inside">
												<li>The number of team members may be limited based on your
												    subscription
												</li>
												<li>Creat avatars for team members!</li>
												<li>If your team accepts applications for potential Negotiators you can
												    also add them here.
												</li>
											</ul>
										</li>
										<li>
											Get an overview and manage settings to suit your needs
											<ul class="ps-5 mt-2 space-y-1 list-decimal list-inside">
												<li>In the top right you will see your name</li>
												<li>Click on it and then click on Admin</li>
												<li>Here you can adjust your subscription, view reports and more...</li>
											</ul>
										</li>
									</ul>
								</div>
							</div>
							<!-- Be sure to use this with a layout container that is full-width on mobile -->
							<div class="overflow-hidden bg-slate-100 col-span-2 shadow-lg sm:rounded-lg">
								<div class="px-4 py-5 sm:p-6">
									<h2 class="text-3xl block font-semibold tracking-tight text-pretty text-gray-900 sm:text-xl dark:text-white">
										Frequently asked questions</h2>
									<div class="lg:col-span-7 lg:mt-8">
										<dl class="space-y-10">
											<div>
												<dt class="text-base/7 font-semibold text-gray-900">Can I change my
												                                                    subscription?
												</dt>
												<dd class="mt-2 text-base/7 text-gray-600">Absolutely! You can change
												                                           your
												                                           subscription at any time by
												                                           clicking on your name in the
												                                           top right of your screen and
												                                           then on Admin.
												</dd>
											</div>

											<div>
												<dt class="text-base/7 font-semibold text-gray-900">If there is a
												                                                    feature I need but
												                                                    is not available,
												                                                    can I request it?
												</dt>
												<dd class="mt-2 text-base/7 text-gray-600">Absolutely! We are always
												                                           looking to improve. If you
												                                           need something reach out and
												                                           we will get back to you as
												                                           soon as possible.
												</dd>
											</div>

											<div>
												<dt class="text-base/7 font-semibold text-gray-900">If I'm unhappy with
												                                                    my subscription can
												                                                    I get a refund?
												</dt>
												<dd class="mt-2 text-base/7 text-gray-600">We do all we can to satisfy
												                                           our customers. If you are
												                                           unhappy with your
												                                           subscription you can cancel
												                                           it at any time by clicking on
												                                           your name in the top right of
												                                           your screen and then on
												                                           Admin.
												</dd>
											</div>

											<!-- More questions... -->
										</dl>
									</div>

								</div>
							</div>

						</div>
					</div>

				</div>
			@endif
		</div>
	</div>
</x-app-layout>