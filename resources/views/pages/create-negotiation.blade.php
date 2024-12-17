<x-app-layout>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			{{-- Card container for the team members content --}}
			<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
				{{-- Main content wrapper inside the card --}}
				<div class="p-6 text-gray-900 dark:text-gray-100">
					{{-- Include the Livewire component to display the team members --}}
					<livewire:forms.create-negotiation />
				</div>
			</div>
		</div>
	</div>
</x-app-layout>