<x-app-layout>
	{{-- Check if there is an active impersonation session --}}
	@if(session()->has('impersonate'))
		{{-- Display a primary banner to notify the user about impersonation.
		     The banner is styled with specific classes for responsiveness and appearance --}}
		<x-banners.primary-banner class="rounded-md max-w-7xl mx-auto mt-2 text-center" />
	@endif
	{{-- Header section of the page --}}
	<x-slot name="header">
		{{-- Display the main header with the title "Team Members" --}}
		<h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
			{{ __('Team Members') }}
			{{-- Provide a description under the header with information about the team members list --}}
			<p class="mt-2 text-sm text-gray-500">A list of all the users in your account including their name,
			                                      title, email and role.</p>
		</h2>
	</x-slot>
	{{-- Main content section of the page --}}
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			{{-- Card container for the team members content --}}
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				{{-- Main content wrapper inside the card --}}
				<div class="p-6 text-gray-900 dark:text-gray-100">
					{{-- Include the Livewire component to display the team members --}}
					<livewire:teams.show-team />
				</div>
			</div>
		</div>
	</div>
</x-app-layout>