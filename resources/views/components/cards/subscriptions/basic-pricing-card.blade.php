@props(['plan'])
<div class="relative rounded-2xl bg-gray-800/80 ring-1 ring-white/10 lg:bg-transparent lg:pb-14 lg:ring-0">
	<div class="p-8 lg:pt-12 xl:p-10 xl:pt-14">
		<h3
				id="tier-starter"
				class="text-sm/6 font-semibold text-white">{{ $plan['name'] }}</h3>
		<div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between lg:flex-col lg:items-stretch">
			<div class="mt-2 flex items-center gap-x-4">
				<!-- Price, update based on frequency toggle state -->
				<p class="text-4xl font-semibold tracking-tight text-white">{{ $plan['price'] }}</p>
				<div class="text-sm">
					<p class="text-white">USD</p>
					<!-- Payment frequency, update based on frequency toggle state -->
					<p class="text-gray-400">Billed monthly</p>
				</div>
			</div>
			<a
					href="#"
					aria-describedby="tier-starter"
					class="rounded-md bg-white/10 px-3 py-2 text-center text-sm/6 font-semibold text-white hover:bg-white/20 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Buy
			                                                                                                                                                                                                     this
			                                                                                                                                                                                                     plan</a>
		</div>
		<div class="mt-8 flow-root sm:mt-10">
			<ul
					role="list"
					class="-my-2 divide-y divide-white/5 border-t border-white/5 text-sm/6 text-white lg:border-t-0">
				@foreach($plan['features'] as $feature)
					<li class="flex gap-x-3 py-2">
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
						{{ $feature['name'] }}
					</li>
				@endforeach
			</ul>
		</div>
	</div>
</div>