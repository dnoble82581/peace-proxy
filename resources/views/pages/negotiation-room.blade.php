<x-negotiation-layout>
	<div class="max-w-[95%] space-y-8 sm:space-y-0 mx-auto sm:grid gap-3 sm:grid-cols-12 pt-8">
		<!-- Left sidebar & main wrapper -->
		<div class="sm:col-span-3">
			<div class="dark:bg-gray-800 bg-white rounded-t p-4">
				<h3 class="text-gray-400 mb2 text-xl pb-4">Live Chat</h3>
				<hr>
			</div>
			<livewire:negotiations.negotiation-chat :room="$room" />
		</div>
		<div class="bg-white dark:bg-gray-800 col-span-6 max-h-[680px] overflow-y-auto p-4 rounded-lg shadow-lg">
			<h3 class="mb-2 text-gray-400 text-xl pb-2">
				Information
				Board</h3>
			<hr>
			<div class="">
				<livewire:negotiations.negotiation-hooks :room="$room" />
			</div>
			<div class="mt-4">
				<livewire:negotiations.negotiation-triggers :room="$room" />
			</div>
			<div>
				<livewire:negotiations.negotiation-demands :room="$room" />
			</div>
		</div>
		<div class="col-span-3 max-h-[680px] overflow-y-auto">
			<div class="">
				<livewire:charts.mood-log-chart :room="$room" />
			</div>
			<livewire:charts.call-log-chart :room="$room" />
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-negotiation-layout>
