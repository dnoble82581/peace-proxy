<x-negotiation-layout>
	<div class="p-4">
		<div class="flex flex-row items-center gap-4">
			<div class="flex-1">
				<livewire:negotiations.negotiation-subject
						:room="$room" />
			</div>
			<div class="flex-1">
				<livewire:negotiations.negotiation-information
						:room="$room" />
			</div>
		</div>
	</div>
	{{--	<div class="pt-4 overflow-hidden pb-8 px-4">--}}
	{{--		<div class="flex items-center gap-3">--}}
	{{--			<div class="flex-1">--}}
	{{--				<livewire:negotiations.negotiation-subject--}}
	{{--						:room="$room" />--}}
	{{--			</div>--}}

	{{--			<div class="flex-1">--}}
	{{--				<livewire:negotiations.negotiation-information--}}
	{{--						:room="$room" />--}}
	{{--			</div>--}}
	{{--		</div>--}}

	{{--		<div class="grid grid-cols-12 gap-4 mt-4">--}}
	{{--			<div class="sm:col-span-3">--}}
	{{--				<div class="bg-white dark:bg-gray-800 rounded-t p-4">--}}
	{{--					<h3 class="text-gray-400 mb-2 text-xl pb-4">Live Chat</h3>--}}
	{{--					<hr>--}}
	{{--				</div>--}}
	{{--				<livewire:negotiations.negotiation-chat :room="$room" />--}}
	{{--			</div>--}}

	{{--			<!-- Main content -->--}}
	{{--			<div--}}
	{{--					id="board"--}}
	{{--					class="bg-white dark:bg-gray-800 rounded-lg shadow-lg col-span-6">--}}
	{{--				<h3 class="mb-2 text-gray-400 text-xl px-2 py-4">Information Board</h3>--}}
	{{--				<hr>--}}
	{{--				<div class="space-y-4 max-h-[610px] overflow-y-auto sticky top-0 overflow-x-hidden">--}}
	{{--					<livewire:negotiations.negotiation-hooks :room="$room" />--}}
	{{--					<livewire:negotiations.negotiation-triggers :room="$room" />--}}
	{{--					<livewire:negotiations.negotiation-demands :room="$room" />--}}
	{{--					<livewire:negotiations.negotiation-associate :room="$room" />--}}
	{{--				</div>--}}
	{{--			</div>--}}

	{{--			<!-- Right-side charts -->--}}
	{{--			<div class="col-span-3 max-h-[680px] overflow-hidden">--}}
	{{--				<x-select--}}
	{{--						class="mb-3"--}}
	{{--						:options="['Mood Log', 'Call Log']" />--}}
	{{--				<div>--}}
	{{--					<livewire:charts.mood-log-chart :room="$room" />--}}
	{{--				</div>--}}
	{{--				<div>--}}
	{{--					<livewire:charts.call-log-chart :room="$room" />--}}
	{{--				</div>--}}
	{{--			</div>--}}
	{{--		</div>--}}
	{{--	</div>--}}
</x-negotiation-layout>

