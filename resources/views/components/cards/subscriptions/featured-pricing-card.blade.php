@props(['plan'])
<div class="relative z-10 rounded-2xl bg-white ring-1 shadow-xl ring-gray-900/10">
	<div class="p-8 lg:pt-12 xl:p-10 xl:pt-14">
		<h3
				id="tier-scale"
				class="text-sm/6 font-semibold text-gray-900">{{ $plan['name'] }}</h3>
		<div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between lg:flex-col lg:items-stretch">
			<div class="mt-2 flex items-center gap-x-4">
				<!-- Price, update based on frequency toggle state -->
				<p class="text-4xl font-semibold tracking-tight text-gray-900">{{ $plan['price'] }}</p>
				<div class="text-sm">
					<p class="text-gray-900">USD</p>
					<!-- Payment frequency, update based on frequency toggle state -->
					<p class="text-gray-500">Billed monthly</p>
				</div>
			</div>

			<a
					href="{{ Auth::check() ? route('dashboard') : route('login') }}"
					class="rounded-md bg-indigo-600 px-3 py-2 w-full text-center text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
				Buy This Plan
			</a>

		</div>
		<div class="mt-8 flow-root sm:mt-10">
			<ul
					role="list"
					class="-my-2 divide-y divide-gray-900/5 border-t border-gray-900/5 text-sm/6 text-gray-600 lg:border-t-0">
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