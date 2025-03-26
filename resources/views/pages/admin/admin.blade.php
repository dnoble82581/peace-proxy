<x-admin-layout>
	<div x-data="{tab: 'dashboard'}">
		<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
		@include('pages.partials.admin._responsive-sidebar')

		<!-- Static sidebar for desktop -->
		@include('pages.partials.admin._static-sidebar')

		<div class="lg:pl-72 bg-[#111010] min-h-screen">
			@include('pages.partials.admin._admin-top-nav')

			<main class="py-10">
				<div
						x-show="tab === 'dashboard'"
						class="px-4 sm:px-6 lg:px-8">
					<livewire:admin.dashboard />
				</div>
				<div
						class="px-4 sm:px-6 lg:px-8"
						x-cloak
						x-show="tab === 'team'">
					<livewire:cards.admin.team-card />
				</div>
				<div
						x-cloak
						x-show="tab === 'negotiations'">
					<livewire:admin.negotiations :tenantId="$tenant->id" />
				</div>
				<div
						x-cloak
						x-show="tab === 'reports'">
					Reports
				</div>
				<div
						class="px-4"
						x-cloak
						x-show="tab === 'settings'">
					<livewire:admin.settings :tenant="$tenant" />
				</div>
			</main>
		</div>
	</div>
</x-admin-layout>