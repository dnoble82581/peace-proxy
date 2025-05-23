<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta
			name="viewport"
			content="width=device-width, initial-scale=1">

	<title>PeaceProxy</title>


	<!-- Styles -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-gray-900">
<section class="bg-gray-900">
	<header class="">
		<nav
				class="flex items-center justify-between p-6 lg:px-8"
				aria-label="Global">
			<div class="flex lg:flex-1">
				<a
						href="#"
						class="-m-1.5 p-1.5">
					<span class="sr-only">Peace Proxy</span>
					<a href="/">
						<x-svg-images.application-logo class="h-8 w-auto fill-slate-300" />
					</a>
				</a>
			</div>
			<div class="flex lg:hidden">
				<button
						type="button"
						class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-400">
					<span class="sr-only">Open main menu</span>
					<svg
							class="size-6"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							aria-hidden="true"
							data-slot="icon">
						<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
					</svg>
				</button>
			</div>
			<div class="hidden lg:flex lg:gap-x-12">
				<a
						href="/"
						class="text-sm/6 font-semibold text-white">Product</a>
				<a
						href="#"
						class="text-sm/6 font-semibold text-white">Features</a>
				<a
						href="{{ route('subscriptions.pricing') }}"
						class="text-sm/6 font-semibold text-white">Pricing</a>
				<a
						href="#"
						class="text-sm/6 font-semibold text-white">Company</a>
			</div>
			<div class="hidden lg:flex lg:flex-1 lg:justify-end">
				<a
						href="{{ route('login') }}"
						class="text-sm/6 font-semibold text-white">Log in <span aria-hidden="true">&rarr;</span></a>
			</div>
		</nav>
		<!-- Mobile menu, show/hide based on menu open state. -->
		<div
				class="lg:hidden"
				role="dialog"
				aria-modal="true">
			<!-- Background backdrop, show/hide based on slide-over state. -->
			<div class="fixed inset-0 z-50"></div>
			<div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-gray-900 px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-white/10">
				<div class="flex items-center justify-between">
					<a
							href="#"
							class="-m-1.5 p-1.5">
						<span class="sr-only">Peace Proxy</span>
						<img
								class="h-8 w-auto"
								src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
								alt="">
					</a>
					<button
							type="button"
							class="-m-2.5 rounded-md p-2.5 text-gray-400">
						<span class="sr-only">Close menu</span>
						<svg
								class="size-6"
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
				<div class="mt-6 flow-root">
					<div class="-my-6 divide-y divide-gray-500/25">
						<div class="space-y-2 py-6">
							<a
									href="/"
									class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">Product</a>
							<a
									href="#"
									class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">Features</a>
							<a
									href="{{ route('subscriptions.pricing') }}"
									class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">Pricing</a>
							<a
									href="#"
									class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-white hover:bg-gray-800">Company</a>
						</div>
						<div class="py-6">
							<a
									href="{{ route('login') }}"
									class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-white hover:bg-gray-800">Log
							                                                                                                          in</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
</section>

<main>
	<div class="isolate overflow-hidden">
		<div class="flow-root bg-gray-900 pt-24 pb-16 sm:pt-32 lg:pb-0">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="relative z-10">
					<h2 class="mx-auto max-w-4xl text-center text-5xl font-semibold tracking-tight text-balance text-white sm:text-6xl">
						Pricing that grows with you</h2>
					<p class="mx-auto mt-6 max-w-2xl text-center text-lg font-medium text-pretty text-gray-400 sm:text-xl/8">
						Choose an affordable plan that’s packed with the best features for engaging your audience,
						creating customer loyalty, and driving sales.</p>
					<div class="mt-16 flex justify-center">
						<fieldset aria-label="Payment frequency">
							<div class="grid grid-cols-2 gap-x-1 rounded-full bg-white/5 p-1 text-center text-xs/5 font-semibold text-white">
								<!-- Checked: "bg-indigo-500" -->
								<label class="cursor-pointer rounded-full px-2.5 py-1 bg-indigo-500">
									<input
											type="radio"
											name="frequency"
											value="monthly"
											class="sr-only">
									<span>Monthly</span>
								</label>
								<!-- Checked: "bg-indigo-500" -->
								<label class="cursor-pointer rounded-full px-2.5 py-1">
									<input
											type="radio"
											name="frequency"
											value="annually"
											class="sr-only">
									<span>Annually</span>
								</label>
							</div>
						</fieldset>
					</div>
				</div>
				<div class="relative mx-auto mt-10 grid max-w-md grid-cols-1 gap-y-8 lg:mx-0 lg:-mb-14 lg:max-w-none lg:grid-cols-3">
					<svg
							viewBox="0 0 1208 1024"
							aria-hidden="true"
							class="absolute -bottom-48 left-1/2 h-[64rem] -translate-x-1/2 translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] lg:-top-48 lg:bottom-auto lg:translate-y-0">
						<ellipse
								cx="604"
								cy="512"
								fill="url(#d25c25d4-6d43-4bf9-b9ac-1842a30a4867)"
								rx="604"
								ry="512" />
						<defs>
							<radialGradient id="d25c25d4-6d43-4bf9-b9ac-1842a30a4867">
								<stop stop-color="#7775D6" />
								<stop
										offset="1"
										stop-color="#E935C1" />
							</radialGradient>
						</defs>
					</svg>
					<div
							class="hidden lg:absolute lg:inset-x-px lg:top-4 lg:bottom-0 lg:block lg:rounded-t-2xl lg:bg-gray-800/80 lg:ring-1 lg:ring-white/10"
							aria-hidden="true"></div>
					@foreach ($plans as $plan)
						@if($plan['name'] === 'Professional Plan')
							<x-cards.subscriptions.featured-pricing-card :plan="$plan" />
						@else
							<x-cards.subscriptions.basic-pricing-card :plan="$plan" />
						@endif
					@endforeach
				</div>
			</div>
		</div>
		<div class="relative bg-gray-50 lg:pt-14">
			<div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8">
				<!-- Feature comparison (up to lg) -->
				<section
						aria-labelledby="mobile-comparison-heading"
						class="lg:hidden">
					<h2
							id="mobile-comparison-heading"
							class="sr-only">Feature comparison</h2>

					<div class="mx-auto max-w-2xl space-y-16">
						<div class="border-t border-gray-900/10">
							<div class="-mt-px w-72 border-t-2 border-transparent pt-10 md:w-80">
								<h3 class="text-sm/6 font-semibold text-gray-900">Starter</h3>
								<p class="mt-1 text-sm/6 text-gray-600">Everything you need to get started.</p>
							</div>

							<div class="mt-10 space-y-10">
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Features</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Edge content delivery</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom domains</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="text-gray-900">1</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Team members</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="text-gray-900">3</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Single sign-on (SSO)</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Reporting</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Advanced analytics</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Basic reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Professional reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom report builder</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Support</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">24/7 online support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Quarterly workshops</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Priority phone support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">1:1 onboarding tour</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="border-t border-gray-900/10">
							<div class="-mt-px w-72 border-t-2 border-indigo-600 pt-10 md:w-80">
								<h3 class="text-sm/6 font-semibold text-indigo-600">Scale</h3>
								<p class="mt-1 text-sm/6 text-gray-600">Added flexibility at scale.</p>
							</div>

							<div class="mt-10 space-y-10">
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Features</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-2 shadow-xs ring-indigo-600 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Edge content delivery</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom domains</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="font-semibold text-indigo-600">Unlimited</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Team members</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="font-semibold text-indigo-600">Unlimited</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Single sign-on (SSO)</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-2 ring-indigo-600 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Reporting</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-2 shadow-xs ring-indigo-600 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Advanced analytics</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Basic reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Professional reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom report builder</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-2 ring-indigo-600 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Support</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-2 shadow-xs ring-indigo-600 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">24/7 online support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Quarterly workshops</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Priority phone support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">1:1 onboarding tour</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-2 ring-indigo-600 sm:block"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="border-t border-gray-900/10">
							<div class="-mt-px w-72 border-t-2 border-transparent pt-10 md:w-80">
								<h3 class="text-sm/6 font-semibold text-gray-900">Growth</h3>
								<p class="mt-1 text-sm/6 text-gray-600">All the extras for your growing team.</p>
							</div>

							<div class="mt-10 space-y-10">
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Features</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Edge content delivery</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom domains</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="text-gray-900">3</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Team members</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<span class="text-gray-900">20</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Single sign-on (SSO)</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Reporting</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Advanced analytics</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Basic reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Professional reports</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Custom report builder</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
								<div>
									<h4 class="text-sm/6 font-semibold text-gray-900">Support</h4>
									<div class="relative mt-6">
										<!-- Fake card background -->
										<div
												aria-hidden="true"
												class="absolute inset-y-0 right-0 hidden w-1/2 rounded-lg bg-white shadow-xs sm:block"></div>

										<div class="relative rounded-lg bg-white ring-1 shadow-xs ring-gray-900/10 sm:rounded-none sm:bg-transparent sm:ring-0 sm:shadow-none">
											<dl class="divide-y divide-gray-200 text-sm/6">
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">24/7 online support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Quarterly workshops</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-indigo-600"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path
																	fill-rule="evenodd"
																	d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
																	clip-rule="evenodd" />
														</svg>
														<span class="sr-only">Yes</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">Priority phone support</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
												<div class="flex items-center justify-between px-4 py-3 sm:grid sm:grid-cols-2 sm:px-0">
													<dt class="pr-4 text-gray-600">1:1 onboarding tour</dt>
													<dd class="flex items-center justify-end sm:justify-center sm:px-4">
														<svg
																class="mx-auto size-5 text-gray-400"
																viewBox="0 0 20 20"
																fill="currentColor"
																aria-hidden="true"
																data-slot="icon">
															<path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
														</svg>
														<span class="sr-only">No</span>
													</dd>
												</div>
											</dl>
										</div>

										<!-- Fake card border -->
										<div
												aria-hidden="true"
												class="pointer-events-none absolute inset-y-0 right-0 hidden w-1/2 rounded-lg ring-1 ring-gray-900/10 sm:block"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>

				<!-- Feature comparison (lg+) -->
				<section
						aria-labelledby="comparison-heading"
						class="hidden lg:block">
					<h2
							id="comparison-heading"
							class="sr-only">Feature comparison</h2>

					<div class="grid grid-cols-4 gap-x-8 border-t border-gray-900/10 before:block">
						<div
								aria-hidden="true"
								class="-mt-px">
							<div class="border-t-2 border-transparent pt-10">
								<p class="text-sm/6 font-semibold text-gray-900">Starter</p>
								<p class="mt-1 text-sm/6 text-gray-600">Everything you need to get started.</p>
							</div>
						</div>
						<div
								aria-hidden="true"
								class="-mt-px">
							<div class="border-t-2 border-indigo-600 pt-10">
								<p class="text-sm/6 font-semibold text-indigo-600">Scale</p>
								<p class="mt-1 text-sm/6 text-gray-600">Added flexibility at scale.</p>
							</div>
						</div>
						<div
								aria-hidden="true"
								class="-mt-px">
							<div class="border-t-2 border-transparent pt-10">
								<p class="text-sm/6 font-semibold text-gray-900">Growth</p>
								<p class="mt-1 text-sm/6 text-gray-600">All the extras for your growing team.</p>
							</div>
						</div>
					</div>

					<div class="-mt-6 space-y-16">
						<div>
							<h3 class="text-sm/6 font-semibold text-gray-900">Features</h3>
							<div class="relative -mx-8 mt-10">
								<!-- Fake card backgrounds -->
								<div
										class="absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
								</div>

								<table class="relative w-full border-separate border-spacing-x-8">
									<thead>
									<tr class="text-left">
										<th scope="col">
											<span class="sr-only">Feature</span>
										</th>
										<th scope="col">
											<span class="sr-only">Starter tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Scale tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Growth tier</span>
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Edge content delivery
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Custom domains
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 text-gray-900">1</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 font-semibold text-indigo-600">Unlimited</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 text-gray-900">3</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Team members
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 text-gray-900">3</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 font-semibold text-indigo-600">Unlimited</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <span class="text-sm/6 text-gray-900">20</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Single sign-on (SSO)
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
									</tr>
									</tbody>
								</table>

								<!-- Fake card borders -->
								<div
										class="pointer-events-none absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
									<div class="rounded-lg ring-2 ring-indigo-600"></div>
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
								</div>
							</div>
						</div>
						<div>
							<h3 class="text-sm/6 font-semibold text-gray-900">Reporting</h3>
							<div class="relative -mx-8 mt-10">
								<!-- Fake card backgrounds -->
								<div
										class="absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
								</div>

								<table class="relative w-full border-separate border-spacing-x-8">
									<thead>
									<tr class="text-left">
										<th scope="col">
											<span class="sr-only">Feature</span>
										</th>
										<th scope="col">
											<span class="sr-only">Starter tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Scale tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Growth tier</span>
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Advanced analytics
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Basic reports
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Professional reports
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Custom report builder
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
									</tr>
									</tbody>
								</table>

								<!-- Fake card borders -->
								<div
										class="pointer-events-none absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
									<div class="rounded-lg ring-2 ring-indigo-600"></div>
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
								</div>
							</div>
						</div>
						<div>
							<h3 class="text-sm/6 font-semibold text-gray-900">Support</h3>
							<div class="relative -mx-8 mt-10">
								<!-- Fake card backgrounds -->
								<div
										class="absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
									<div class="size-full rounded-lg bg-white shadow-xs"></div>
								</div>

								<table class="relative w-full border-separate border-spacing-x-8">
									<thead>
									<tr class="text-left">
										<th scope="col">
											<span class="sr-only">Feature</span>
										</th>
										<th scope="col">
											<span class="sr-only">Starter tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Scale tier</span>
										</th>
										<th scope="col">
											<span class="sr-only">Growth tier</span>
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											24/7 online support
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Quarterly workshops
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											Priority phone support
											<div class="absolute inset-x-8 mt-3 h-px bg-gray-200"></div>
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
									</tr>
									<tr>
										<th
												scope="row"
												class="w-1/4 py-3 pr-4 text-left text-sm/6 font-normal text-gray-900">
											1:1 onboarding tour
										</th>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-indigo-600"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path
		                          fill-rule="evenodd"
		                          d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
		                          clip-rule="evenodd" />
                        </svg>
                        <span class="sr-only">Yes</span>
                      </span>
										</td>
										<td class="relative w-1/4 px-4 py-0 text-center">
                      <span class="relative size-full py-3">
                        <svg
		                        class="mx-auto size-5 text-gray-400"
		                        viewBox="0 0 20 20"
		                        fill="currentColor"
		                        aria-hidden="true"
		                        data-slot="icon">
                          <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                        </svg>
                        <span class="sr-only">No</span>
                      </span>
										</td>
									</tr>
									</tbody>
								</table>

								<!-- Fake card borders -->
								<div
										class="pointer-events-none absolute inset-x-8 inset-y-0 grid grid-cols-4 gap-x-8 before:block"
										aria-hidden="true">
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
									<div class="rounded-lg ring-2 ring-indigo-600"></div>
									<div class="rounded-lg ring-1 ring-gray-900/10"></div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>
</main>


<footer class="bg-gray-900">
	<div class="mx-auto max-w-7xl px-6 pb-8 pt-16 sm:pt-24 lg:px-8 lg:pt-32">
		<div class="xl:grid xl:grid-cols-3 xl:gap-8">
			<div class="space-y-8">
				<x-svg-images.application-logo class="h-12 w-auto fill-slate-100" />
				<p class="text-balance text-sm/6 text-gray-300">Making the world a better place through constructing
				                                                elegant hierarchies.</p>
				<div class="flex gap-x-6">
					<a
							href="#"
							class="text-gray-400 hover:text-gray-300">
						<span class="sr-only">Facebook</span>
						<svg
								class="size-6"
								fill="currentColor"
								viewBox="0 0 24 24"
								aria-hidden="true">
							<path
									fill-rule="evenodd"
									d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
									clip-rule="evenodd" />
						</svg>
					</a>
					<a
							href="#"
							class="text-gray-400 hover:text-gray-300">
						<span class="sr-only">Instagram</span>
						<svg
								class="size-6"
								fill="currentColor"
								viewBox="0 0 24 24"
								aria-hidden="true">
							<path
									fill-rule="evenodd"
									d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
									clip-rule="evenodd" />
						</svg>
					</a>
					<a
							href="#"
							class="text-gray-400 hover:text-gray-300">
						<span class="sr-only">X</span>
						<svg
								class="size-6"
								fill="currentColor"
								viewBox="0 0 24 24"
								aria-hidden="true">
							<path d="M13.6823 10.6218L20.2391 3H18.6854L12.9921 9.61788L8.44486 3H3.2002L10.0765 13.0074L3.2002 21H4.75404L10.7663 14.0113L15.5685 21H20.8131L13.6819 10.6218H13.6823ZM11.5541 13.0956L10.8574 12.0991L5.31391 4.16971H7.70053L12.1742 10.5689L12.8709 11.5655L18.6861 19.8835H16.2995L11.5541 13.096V13.0956Z" />
						</svg>
					</a>
					<a
							href="#"
							class="text-gray-400 hover:text-gray-300">
						<span class="sr-only">GitHub</span>
						<svg
								class="size-6"
								fill="currentColor"
								viewBox="0 0 24 24"
								aria-hidden="true">
							<path
									fill-rule="evenodd"
									d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
									clip-rule="evenodd" />
						</svg>
					</a>
					<a
							href="#"
							class="text-gray-400 hover:text-gray-300">
						<span class="sr-only">YouTube</span>
						<svg
								class="size-6"
								fill="currentColor"
								viewBox="0 0 24 24"
								aria-hidden="true">
							<path
									fill-rule="evenodd"
									d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z"
									clip-rule="evenodd" />
						</svg>
					</a>
				</div>
			</div>
			<div class="mt-16 grid grid-cols-2 gap-8 xl:col-span-2 xl:mt-0">
				<div class="md:grid md:grid-cols-2 md:gap-8">
					<div>
						<h3 class="text-sm/6 font-semibold text-white">Solutions</h3>
						<ul
								role="list"
								class="mt-6 space-y-4">
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Marketing</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Analytics</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Automation</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Commerce</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Insights</a>
							</li>
						</ul>
					</div>
					<div class="mt-10 md:mt-0">
						<h3 class="text-sm/6 font-semibold text-white">Support</h3>
						<ul
								role="list"
								class="mt-6 space-y-4">
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Submit ticket</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Documentation</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Guides</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="md:grid md:grid-cols-2 md:gap-8">
					<div>
						<h3 class="text-sm/6 font-semibold text-white">Company</h3>
						<ul
								role="list"
								class="mt-6 space-y-4">
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">About</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Blog</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Jobs</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Press</a>
							</li>
						</ul>
					</div>
					<div class="mt-10 md:mt-0">
						<h3 class="text-sm/6 font-semibold text-white">Legal</h3>
						<ul
								role="list"
								class="mt-6 space-y-4">
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Terms of service</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">Privacy policy</a>
							</li>
							<li>
								<a
										href="#"
										class="text-sm/6 text-gray-400 hover:text-white">License</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="mt-16 border-t border-white/10 pt-8 sm:mt-20 lg:mt-24">
			<p class="text-sm/6 text-gray-400">&copy; 2024 Peace Proxy, Inc. All rights reserved.</p>
		</div>
	</div>
</footer>
<script src="https://js.stripe.com/v3/"></script>
<script>
	const stripe = Stripe('{{ config('stripe.publishable_key') }}')
	const elements = stripe.elements()

	const cardElement = elements.create('card')
	cardElement.mount('#card-element')

	const form = document.querySelector('form')
	form.addEventListener('submit', async (event) => {
		event.preventDefault()
		const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement)
		if (error) {
			document.querySelector('#card-errors').textContent = error.message
		} else {
			document.querySelector('#payment-method').value = paymentMethod.id
			form.submit()
		}
	})
</script>
</body>
</html>



