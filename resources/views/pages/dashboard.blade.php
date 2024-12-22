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
		</div>
	</div>
</x-app-layout>