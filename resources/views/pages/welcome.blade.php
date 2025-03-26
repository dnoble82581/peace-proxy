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
	<header class="absolute inset-x-0 top-0 z-50">
		<nav
				class="flex items-center justify-between p-6 lg:px-8"
				aria-label="Global">
			<div class="flex lg:flex-1">
				<a
						href="#"
						class="-m-1.5 p-1.5">
					<span class="sr-only">Peace Proxy</span>
					<x-svg-images.application-logo class="h-8 w-auto fill-slate-300" />
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
						href="#"
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
									href="#"
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

	<div class="relative isolate pt-14">
		<div
				class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
				aria-hidden="true">
			<div
					class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
					style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
		</div>
		<div class="py-24 sm:py-32 lg:pb-40">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="mx-auto max-w-2xl text-center">
					<h1 class="text-balance text-5xl font-semibold tracking-tight text-white sm:text-7xl">Innovative
					                                                                                      Solutions for
					                                                                                      High-Stakes
					                                                                                      Conversations</h1>
					<p class="mt-8 text-pretty text-lg font-medium text-gray-400 sm:text-xl/8">With features designed to
					                                                                           enhance preparation and
					                                                                           on-the-spot adaptability,
					                                                                           this software equips
					                                                                           professionals with a
					                                                                           competitive edge in
					                                                                           resolving complex crises
					                                                                           efficiently and
					                                                                           safely.</p>
					<div class="mt-10 flex items-center justify-center gap-x-6">
						<a
								href="{{ route('register') }}"
								class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-400">Get
						                                                                                                                                                                                                                                    started</a>
						<a
								href="#"
								class="text-sm/6 font-semibold text-white">Learn more <span aria-hidden="true">→</span></a>
					</div>
				</div>
				<img
						src="https://peace-proxy-public.s3.us-east-1.amazonaws.com/Assets/Screenshot%2B2025-02-04%2Bat%2B12.57.37%E2%80%AFAM.png"
						alt="App screenshot"
						width="2432"
						height="1442"
						class="mt-16 rounded-md bg-white/5 shadow-2xl ring-1 ring-white/10 sm:mt-24">
			</div>
		</div>
		<div
				class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
				aria-hidden="true">
			<div
					class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
					style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
		</div>
	</div>
</section>
<div class="overflow-hidden bg-gray-900 py-24 sm:py-32">
	<div class="mx-auto max-w-7xl px-6 lg:px-8">
		<div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 sm:gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
			<div class="lg:pr-8 lg:pt-4">
				<div class="lg:max-w-lg">
					<h2 class="text-base/7 font-semibold text-indigo-400">Work Smarter</h2>
					<p class="mt-2 text-pretty text-4xl font-semibold tracking-tight text-white sm:text-5xl">A better
					                                                                                         workflow</p>
					<p class="mt-6 text-lg/8 text-gray-300">Traditional crisis negotiation relies on radios and manual
					                                        note-taking, which can be slow and error-prone. This web app
					                                        offers live chat for immediate communication and automatic
					                                        report generation, enhancing both the speed and reliability
					                                        of the negotiation process.</p>
					<dl class="mt-10 max-w-xl space-y-8 text-base/7 text-gray-300 lg:max-w-none">
						<div class="relative pl-9">
							<dt class="inline font-semibold text-white">
								<svg
										class="absolute left-1 top-1 size-5 text-indigo-500"
										viewBox="0 0 20 20"
										fill="currentColor"
										aria-hidden="true"
										data-slot="icon">
									<path
											fill-rule="evenodd"
											d="M5.5 17a4.5 4.5 0 0 1-1.44-8.765 4.5 4.5 0 0 1 8.302-3.046 3.5 3.5 0 0 1 4.504 4.272A4 4 0 0 1 15 17H5.5Zm3.75-2.75a.75.75 0 0 0 1.5 0V9.66l1.95 2.1a.75.75 0 1 0 1.1-1.02l-3.25-3.5a.75.75 0 0 0-1.1 0l-3.25 3.5a.75.75 0 1 0 1.1 1.02l1.95-2.1v4.59Z"
											clip-rule="evenodd" />
								</svg>
								Real-Time Communication:
							</dt>
							<dd class="inline">Enables instant live chat, allowing police officers to coordinate and
							                   respond immediately during fast-moving crisis situations.
							</dd>
						</div>
						<div class="relative pl-9">
							<dt class="inline font-semibold text-white">
								<svg
										class="absolute left-1 top-1 size-5 text-indigo-500"
										viewBox="0 0 20 20"
										fill="currentColor"
										aria-hidden="true"
										data-slot="icon">
									<path
											fill-rule="evenodd"
											d="M10 1a4.5 4.5 0 0 0-4.5 4.5V9H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6a2 2 0 0 0-2-2h-.5V5.5A4.5 4.5 0 0 0 10 1Zm3 8V5.5a3 3 0 1 0-6 0V9h6Z"
											clip-rule="evenodd" />
								</svg>
								Comprehensive Activity Tracking:
							</dt>
							<dd class="inline">Automatically logs all interactions, providing an accurate and complete
							                   record for accountability, training, and legal analysis.
							</dd>
						</div>
						<div class="relative pl-9">
							<dt class="inline font-semibold text-white">
								<svg
										class="absolute left-1 top-1 size-5 text-indigo-500"
										viewBox="0 0 20 20"
										fill="currentColor"
										aria-hidden="true"
										data-slot="icon">
									<path d="M4.632 3.533A2 2 0 0 1 6.577 2h6.846a2 2 0 0 1 1.945 1.533l1.976 8.234A3.489 3.489 0 0 0 16 11.5H4c-.476 0-.93.095-1.344.267l1.976-8.234Z" />
									<path
											fill-rule="evenodd"
											d="M4 13a2 2 0 1 0 0 4h12a2 2 0 1 0 0-4H4Zm11.24 2a.75.75 0 0 1 .75-.75H16a.75.75 0 0 1 .75.75v.01a.75.75 0 0 1-.75.75h-.01a.75.75 0 0 1-.75-.75V15Zm-2.25-.75a.75.75 0 0 0-.75.75v.01c0 .414.336.75.75.75H13a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75h-.01Z"
											clip-rule="evenodd" />
								</svg>
								Efficient Report Generation:
							</dt>
							<dd class="inline">Produces detailed reports automatically from tracked data, saving time
							                   and ensuring compliance with legal requirements.
							</dd>
						</div>
					</dl>
				</div>
			</div>
			<img
					src="https://peace-proxy-public.s3.us-east-1.amazonaws.com/Assets/Screenshot%2B2025-02-04%2Bat%2B12.57.37%E2%80%AFAM.png"
					alt="Product screenshot"
					class="w-[48rem] max-w-none rounded-xl shadow-xl ring-1 ring-white/10 sm:w-[57rem] md:-ml-4 lg:-ml-0"
					width="2432"
					height="1442">
		</div>
	</div>
</div>
<div class="bg-white">
	<div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8">
		<div class="relative isolate overflow-hidden bg-gray-900 px-6 pt-16 shadow-2xl sm:rounded-3xl sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-24 lg:pt-0">
			<svg
					viewBox="0 0 1024 1024"
					class="absolute left-1/2 top-1/2 -z-10 size-[64rem] -translate-y-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:left-full sm:-ml-80 lg:left-1/2 lg:ml-0 lg:-translate-x-1/2 lg:translate-y-0"
					aria-hidden="true">
				<circle
						cx="512"
						cy="512"
						r="512"
						fill="url(#759c1415-0410-454c-8f7c-9a820de03641)"
						fill-opacity="0.7" />
				<defs>
					<radialGradient id="759c1415-0410-454c-8f7c-9a820de03641">
						<stop stop-color="#7775D6" />
						<stop
								offset="1"
								stop-color="#E935C1" />
					</radialGradient>
				</defs>
			</svg>
			<div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-32 lg:text-left">
				<h2 class="text-balance text-3xl font-semibold tracking-tight text-white sm:text-4xl">Respond Faster,
				                                                                                      Report Smarter.
				                                                                                      Elevate Your
				                                                                                      Crisis
				                                                                                      Negotiations.</h2>
				<p class="mt-6 text-pretty text-lg/8 text-gray-300">Changing the way Crisis Negotiation is done.</p>
				<div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
					<a
							href="#"
							class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get
					                                                                                                                                                                                                                           started</a>
					<a
							href="#"
							class="text-sm/6 font-semibold text-white">Learn more <span aria-hidden="true">→</span></a>
				</div>
			</div>
			<div class="relative mt-16 h-80 lg:mt-8">
				<img
						class="absolute left-0 top-0 w-[57rem] max-w-none rounded-md bg-white/5 ring-1 ring-white/10"
						src="https://peace-proxy-public.s3.us-east-1.amazonaws.com/Assets/Screenshot%2B2025-02-04%2Bat%2B12.59.08%E2%80%AFAM.png"
						alt="App screenshot"
						width="1824"
						height="1080">
			</div>
		</div>
	</div>
</div>
<div class="bg-gray-900 py-24 sm:py-32">
	<div class="mx-auto max-w-2xl px-6 lg:max-w-7xl lg:px-8">
		<h2 class="text-base/7 font-semibold text-indigo-400">Deploy faster</h2>
		<p class="mt-2 max-w-lg text-pretty text-4xl font-semibold tracking-tight text-white sm:text-5xl">Everything you
		                                                                                                  need to deploy
		                                                                                                  your app</p>
		<div class="mt-10 grid grid-cols-1 gap-4 sm:mt-16 lg:grid-cols-6 lg:grid-rows-2">
			<div class="flex p-px lg:col-span-4">
				<div class="overflow-hidden rounded-lg bg-gray-800 ring-1 ring-white/15 max-lg:rounded-t-[2rem] lg:rounded-tl-[2rem]">
					<img
							class="h-80 object-cover object-left"
							src="https://tailwindui.com/plus/img/component-images/bento-02-releases.png"
							alt="">
					<div class="p-10">
						<h3 class="text-sm/4 font-semibold text-gray-400">Releases</h3>
						<p class="mt-2 text-lg font-medium tracking-tight text-white">Push to deploy</p>
						<p class="mt-2 max-w-lg text-sm/6 text-gray-400">Lorem ipsum dolor sit amet, consectetur
						                                                 adipiscing elit. In gravida justo et nulla
						                                                 efficitur, maximus egestas sem
						                                                 pellentesque.</p>
					</div>
				</div>
			</div>
			<div class="flex p-px lg:col-span-2">
				<div class="overflow-hidden rounded-lg bg-gray-800 ring-1 ring-white/15 lg:rounded-tr-[2rem]">
					<img
							class="h-80 object-cover"
							src="https://tailwindui.com/plus/img/component-images/bento-02-integrations.png"
							alt="">
					<div class="p-10">
						<h3 class="text-sm/4 font-semibold text-gray-400">Integrations</h3>
						<p class="mt-2 text-lg font-medium tracking-tight text-white">Connect your favorite tools</p>
						<p class="mt-2 max-w-lg text-sm/6 text-gray-400">Curabitur auctor, ex quis auctor venenatis,
						                                                 eros arcu rhoncus massa.</p>
					</div>
				</div>
			</div>
			<div class="flex p-px lg:col-span-2">
				<div class="overflow-hidden rounded-lg bg-gray-800 ring-1 ring-white/15 lg:rounded-bl-[2rem]">
					<img
							class="h-80 object-cover"
							src="https://tailwindui.com/plus/img/component-images/bento-02-security.png"
							alt="">
					<div class="p-10">
						<h3 class="text-sm/4 font-semibold text-gray-400">Security</h3>
						<p class="mt-2 text-lg font-medium tracking-tight text-white">Advanced access control</p>
						<p class="mt-2 max-w-lg text-sm/6 text-gray-400">Vestibulum ante ipsum primis in faucibus orci
						                                                 luctus et ultrices posuere cubilia.</p>
					</div>
				</div>
			</div>
			<div class="flex p-px lg:col-span-4">
				<div class="overflow-hidden rounded-lg bg-gray-800 ring-1 ring-white/15 max-lg:rounded-b-[2rem] lg:rounded-br-[2rem]">
					<img
							class="h-80 object-cover object-left"
							src="https://tailwindui.com/plus/img/component-images/bento-02-performance.png"
							alt="">
					<div class="p-10">
						<h3 class="text-sm/4 font-semibold text-gray-400">Performance</h3>
						<p class="mt-2 text-lg font-medium tracking-tight text-white">Lightning-fast builds</p>
						<p class="mt-2 max-w-lg text-sm/6 text-gray-400">Sed congue eros non finibus molestie.
						                                                 Vestibulum euismod augue vel commodo vulputate.
						                                                 Maecenas at augue sed elit dictum
						                                                 vulputate.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="isolate overflow-hidden bg-gray-900">
	<div class="mx-auto max-w-7xl px-6 pb-96 pt-24 text-center sm:pt-32 lg:px-8">
		<div class="mx-auto max-w-4xl">
			<h2 class="text-base/7 font-semibold text-indigo-400">Pricing</h2>
			<p class="mt-2 text-balance text-5xl font-semibold tracking-tight text-white sm:text-6xl">Choose the right
			                                                                                          plan for you</p>
		</div>
		<div class="relative mt-6">
			<p class="mx-auto max-w-2xl text-pretty text-lg font-medium text-gray-400 sm:text-xl/8">Choose an affordable
			                                                                                        plan that’s packed
			                                                                                        with the best
			                                                                                        features for
			                                                                                        engaging your
			                                                                                        audience, creating
			                                                                                        customer loyalty,
			                                                                                        and driving
			                                                                                        sales.</p>
			<svg
					viewBox="0 0 1208 1024"
					class="absolute -top-10 left-1/2 -z-10 h-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)] sm:-top-12 md:-top-20 lg:-top-12 xl:top-0">
				<ellipse
						cx="604"
						cy="512"
						fill="url(#6d1bd035-0dd1-437e-93fa-59d316231eb0)"
						rx="604"
						ry="512" />
				<defs>
					<radialGradient id="6d1bd035-0dd1-437e-93fa-59d316231eb0">
						<stop stop-color="#7775D6" />
						<stop
								offset="1"
								stop-color="#E935C1" />
					</radialGradient>
				</defs>
			</svg>
		</div>
	</div>
	<div class="flow-root bg-white pb-24 sm:pb-32">
		<div class="-mt-80">
			<div class="mx-auto max-w-7xl px-6 lg:px-8">
				<div class="mx-auto grid max-w-md grid-cols-1 gap-8 lg:max-w-4xl lg:grid-cols-2">
					<div class="flex flex-col justify-between rounded-3xl bg-white p-8 shadow-xl ring-1 ring-gray-900/10 sm:p-10">
						<div>
							<h3
									id="tier-hobby"
									class="text-base/7 font-semibold text-indigo-600">Hobby</h3>
							<div class="mt-4 flex items-baseline gap-x-2">
								<span class="text-5xl font-semibold tracking-tight text-gray-900">$29</span>
								<span class="text-base/7 font-semibold text-gray-600">/month</span>
							</div>
							<p class="mt-6 text-base/7 text-gray-600">Modi dolorem expedita deleniti. Corporis iste qui
							                                          inventore pariatur adipisci vitae.</p>
							<ul
									role="list"
									class="mt-10 space-y-4 text-sm/6 text-gray-600">
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									5 products
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Up to 1,000 subscribers
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Basic analytics
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									48-hour support response time
								</li>
							</ul>
						</div>
						<a
								href="#"
								aria-describedby="tier-hobby"
								class="mt-8 block rounded-md bg-indigo-600 px-3.5 py-2 text-center text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get
						                                                                                                                                                                                                                                                           started
						                                                                                                                                                                                                                                                           today</a>
					</div>
					<div class="flex flex-col justify-between rounded-3xl bg-white p-8 shadow-xl ring-1 ring-gray-900/10 sm:p-10">
						<div>
							<h3
									id="tier-team"
									class="text-base/7 font-semibold text-indigo-600">Team</h3>
							<div class="mt-4 flex items-baseline gap-x-2">
								<span class="text-5xl font-semibold tracking-tight text-gray-900">$99</span>
								<span class="text-base/7 font-semibold text-gray-600">/month</span>
							</div>
							<p class="mt-6 text-base/7 text-gray-600">Explicabo quo fugit vel facere ullam corrupti non
							                                          dolores. Expedita eius sit sequi.</p>
							<ul
									role="list"
									class="mt-10 space-y-4 text-sm/6 text-gray-600">
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Unlimited products
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Unlimited subscribers
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Advanced analytics
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									1-hour, dedicated support response time
								</li>
								<li class="flex gap-x-3">
									<svg
											class="h-6 w-5 flex-none text-indigo-600"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
												clip-rule="evenodd" />
									</svg>
									Marketing automations
								</li>
							</ul>
						</div>
						<a
								href="#"
								aria-describedby="tier-team"
								class="mt-8 block rounded-md bg-indigo-600 px-3.5 py-2 text-center text-sm/6 font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Get
						                                                                                                                                                                                                                                                           started
						                                                                                                                                                                                                                                                           today</a>
					</div>

					<div class="flex flex-col items-start gap-x-8 gap-y-6 rounded-3xl p-8 ring-1 ring-gray-900/10 sm:gap-y-10 sm:p-10 lg:col-span-2 lg:flex-row lg:items-center">
						<div class="lg:min-w-0 lg:flex-1">
							<h3 class="text-base/7 font-semibold text-indigo-600">Discounted</h3>
							<p class="mt-1 text-base/7 text-gray-600">Dolor dolores repudiandae doloribus. Rerum sunt
							                                          aut eum. Odit omnis non voluptatem sunt eos
							                                          nostrum.</p>
						</div>
						<a
								href="#"
								class="rounded-md px-3.5 py-2 text-sm/6 font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-200 hover:ring-indigo-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Buy
						                                                                                                                                                                                                                                                     discounted
						                                                                                                                                                                                                                                                     license
							<span aria-hidden="true">&rarr;</span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="relative isolate bg-gray-900">
	<div class="mx-auto grid max-w-7xl grid-cols-1 lg:grid-cols-2">
		<div class="relative px-6 pb-20 pt-24 sm:pt-32 lg:static lg:px-8 lg:py-48">
			<div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
				<div class="absolute inset-y-0 left-0 -z-10 w-full overflow-hidden ring-1 ring-white/5 lg:w-1/2">
					<svg
							class="absolute inset-0 size-full stroke-gray-700 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
							aria-hidden="true">
						<defs>
							<pattern
									id="54f88622-e7f8-4f1d-aaf9-c2f5e46dd1f2"
									width="200"
									height="200"
									x="100%"
									y="-1"
									patternUnits="userSpaceOnUse">
								<path
										d="M130 200V.5M.5 .5H200"
										fill="none" />
							</pattern>
						</defs>
						<svg
								x="100%"
								y="-1"
								class="overflow-visible fill-gray-800/20">
							<path
									d="M-470.5 0h201v201h-201Z"
									stroke-width="0" />
						</svg>
						<rect
								width="100%"
								height="100%"
								stroke-width="0"
								fill="url(#54f88622-e7f8-4f1d-aaf9-c2f5e46dd1f2)" />
					</svg>
					<div
							class="absolute -left-56 top-[calc(100%-13rem)] transform-gpu blur-3xl lg:left-[max(-14rem,calc(100%-59rem))] lg:top-[calc(50%-7rem)]"
							aria-hidden="true">
						<div
								class="aspect-[1155/678] w-[72.1875rem] bg-gradient-to-br from-[#80caff] to-[#4f46e5] opacity-20"
								style="clip-path: polygon(74.1% 56.1%, 100% 38.6%, 97.5% 73.3%, 85.5% 100%, 80.7% 98.2%, 72.5% 67.7%, 60.2% 37.8%, 52.4% 32.2%, 47.5% 41.9%, 45.2% 65.8%, 27.5% 23.5%, 0.1% 35.4%, 17.9% 0.1%, 27.6% 23.5%, 76.1% 2.6%, 74.1% 56.1%)"></div>
					</div>
				</div>
				<h2 class="text-pretty text-4xl font-semibold tracking-tight text-white sm:text-5xl">Get in touch</h2>
				<p class="mt-6 text-lg/8 text-gray-300">Proin volutpat consequat porttitor cras nullam gravida at. Orci
				                                        molestie a eu arcu. Sed ut tincidunt integer elementum id sem.
				                                        Arcu sed malesuada et magna.</p>
				<dl class="mt-10 space-y-4 text-base/7 text-gray-300">
					<div class="flex gap-x-4">
						<dt class="flex-none">
							<span class="sr-only">Address</span>
							<svg
									class="h-7 w-6 text-gray-400"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
							</svg>
						</dt>
						<dd>Iowa City, Iowa</dd>
					</div>
					<div class="flex gap-x-4">
						<dt class="flex-none">
							<span class="sr-only">Telephone</span>
							<svg
									class="h-7 w-6 text-gray-400"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
							</svg>
						</dt>
						<dd><a
									class="hover:text-white"
									href="tel:+1 (555) 234-5678">+1(319)-594-7290</a></dd>
					</div>
					<div class="flex gap-x-4">
						<dt class="flex-none">
							<span class="sr-only">Email</span>
							<svg
									class="h-7 w-6 text-gray-400"
									fill="none"
									viewBox="0 0 24 24"
									stroke-width="1.5"
									stroke="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path
										stroke-linecap="round"
										stroke-linejoin="round"
										d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
							</svg>
						</dt>
						<dd><a
									class="hover:text-white"
									href="mailto:hello@example.com">dnoble82581@gmail.com</a></dd>
					</div>
				</dl>
			</div>
		</div>
		<form
				action="#"
				method="POST"
				class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48">
			<div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
				<div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
					<div>
						<label
								for="first-name"
								class="block text-sm/6 font-semibold text-white">First name</label>
						<div class="mt-2.5">
							<input
									type="text"
									name="first-name"
									id="first-name"
									autocomplete="given-name"
									class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
						</div>
					</div>
					<div>
						<label
								for="last-name"
								class="block text-sm/6 font-semibold text-white">Last name</label>
						<div class="mt-2.5">
							<input
									type="text"
									name="last-name"
									id="last-name"
									autocomplete="family-name"
									class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
						</div>
					</div>
					<div class="sm:col-span-2">
						<label
								for="email"
								class="block text-sm/6 font-semibold text-white">Email</label>
						<div class="mt-2.5">
							<input
									type="email"
									name="email"
									id="email"
									autocomplete="email"
									class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
						</div>
					</div>
					<div class="sm:col-span-2">
						<label
								for="phone-number"
								class="block text-sm/6 font-semibold text-white">Phone number</label>
						<div class="mt-2.5">
							<input
									type="tel"
									name="phone-number"
									id="phone-number"
									autocomplete="tel"
									class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500">
						</div>
					</div>
					<div class="sm:col-span-2">
						<label
								for="message"
								class="block text-sm/6 font-semibold text-white">Message</label>
						<div class="mt-2.5">
							<textarea
									name="message"
									id="message"
									rows="4"
									class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500"></textarea>
						</div>
					</div>
				</div>
				<div class="mt-8 flex justify-end">
					<button
							type="submit"
							class="rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
						Send message
					</button>
				</div>
			</div>
		</form>
	</div>
</div>
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
</body>
</html>


