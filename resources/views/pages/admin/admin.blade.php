<x-admin-layout>
	<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-white">
  <body class="h-full">
  ```
-->
	<div x-data="{tab: 'dashboard'}">
		<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
		@include('pages.partials.admin._responsive-sidebar')

		<!-- Static sidebar for desktop -->
		@include('pages.partials.admin._static-sidebar')

		<div class="lg:pl-72">
			@include('pages.partials.admin._admin-top-nav')

			<main class="py-10">
				<div
						x-show="tab === 'dashboard'"
						class="px-4 sm:px-6 lg:px-8">
					<div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-6 gap-6">
						<livewire:charts.negotiations-chart />
						<livewire:charts.resolutions-chart />
						<livewire:data.30-day-summary />
					</div>
				</div>
				<div x-show="tab === 'team'">
					<livewire:teams.show-team />
				</div>
				<div x-show="tab === 'negotiations'">
					<livewire:admin.documents />
				</div>
				<div x-show="tab === 'reports'">
					Reports
				</div>
			</main>
		</div>
	</div>

</x-admin-layout>