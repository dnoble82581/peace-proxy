<x-app-layout>
	<div class="bg-white py-24 sm:py-32">
		<div class="mx-auto max-w-7xl px-6 lg:px-8">
			<div class="mx-auto max-w-4xl text-center">
				<h2 class="text-base/7 font-semibold text-indigo-600">Pricing</h2>
				<p class="mt-2 text-5xl font-semibold tracking-tight text-balance text-gray-900 sm:text-6xl">Pricing
				                                                                                             that grows
				                                                                                             with
				                                                                                             you</p>
			</div>
			<p class="mx-auto mt-6 max-w-2xl text-center text-lg font-medium text-pretty text-gray-600 sm:text-xl/8">
				Choose an affordable plan that’s packed with the best features for engaging your audience, creating
				customer loyalty, and driving sales.</p>
			<div class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
				@foreach($plans as $plan)
					@if($plan['name'] === 'Professional Plan')
						<x-cards.subscriptions.auth-featured-pricing-card
								:plan="$plan"
								:loop="$loop" />
					@else
						<x-cards.subscriptions.auth-basic-pricing-card
								:plan="$plan"
								:loop="$loop" />
					@endif
				@endforeach
			</div>
		</div>
	</div>
</x-app-layout>