@props(['plan', 'loop'])
<div
		class="flex flex-col justify-between rounded-3xl bg-white p-8 ring-1 ring-gray-200 lg:mt-8  {{ $loop->first ? 'lg:rounded-l-3xl lg:rounded-r-none' : ($loop->last ? 'lg:rounded-r-3xl lg:rounded-l-none' : 'lg:rounded-l-none lg:rounded-r-none') }}
 xl:p-10">
	<div>
		<div class="flex items-center justify-between gap-x-4">
			<h3
					id="tier-freelancer"
					class="text-lg/8 font-semibold text-gray-900">{{ $plan['name'] }}</h3>
		</div>
		<p class="mt-4 text-sm/6 text-gray-600">The essentials to provide your best work for
		                                        clients.</p>
		<p class="mt-6 flex items-baseline gap-x-1">
			<span class="text-4xl font-semibold tracking-tight text-gray-900">{{ $plan['price'] }}</span>
			<span class="text-sm/6 font-semibold text-gray-600">/month</span>
		</p>
		<ul
				role="list"
				class="mt-8 space-y-3 text-sm/6 text-gray-600">
			@foreach($plan['features'] as $feature)
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
					{{ $feature['name'] }}
				</li>
			@endforeach

		</ul>
	</div>
	<form
			method="post"
			action="{{ route('subscriptions.subscribe') }}">
		@csrf
		<input
				type="hidden"
				name="price_id"
				value="{{ $plan['price_id'] }}">
		<button
				type="submit"
				aria-describedby="{{ $plan['name'] }}"
				class="mt-8 block w-full rounded-md bg-indigo-600 px-3 py-2 text-center text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
			Buy
			plan
		</button>
	</form>
</div>