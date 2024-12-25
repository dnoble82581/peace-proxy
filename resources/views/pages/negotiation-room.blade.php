<x-negotiation-layout>
	<div class="max-w-full w-full mx-auto sm:grid sm:grid-cols-12 sm:gap-3 pt-4 overflow-hidden pb-8 px-4">
		<livewire:negotiations.negotiation-subject :room="$room" />
		<x-cards.negotiation-information :negotiation="$room->negotiation" />

		<!-- Left sidebar & main wrapper -->
		<div class="sm:col-span-3">
			<div class="bg-white dark:bg-gray-800 rounded-t p-4">
				<h3 class="text-gray-400 mb-2 text-xl pb-4">Live Chat</h3>
				<hr>
			</div>
			<livewire:negotiations.negotiation-chat :room="$room" />
		</div>

		<!-- Main content -->
		<div
				id="board"
				class="bg-white dark:bg-gray-800 rounded-lg shadow-lg col-span-6">
			<h3 class="mb-2 text-gray-400 text-xl px-2 py-4">Information Board</h3>
			<hr>
			<div class="space-y-4 max-h-[610px] overflow-y-auto sticky top-0 overflow-x-hidden">
				<livewire:negotiations.negotiation-hooks :room="$room" />
				<livewire:negotiations.negotiation-triggers :room="$room" />
				<livewire:negotiations.negotiation-demands :room="$room" />
			</div>
		</div>

		<!-- Right-side charts -->
		<div class="col-span-3 max-h-[680px] overflow-hidden">
			<div>
				<livewire:charts.mood-log-chart :room="$room" />
			</div>
			<div>
				<livewire:charts.call-log-chart :room="$room" />
			</div>
		</div>
	</div>

</x-negotiation-layout>