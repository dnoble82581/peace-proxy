<?php

	use App\Models\Room;
	use App\Models\Subject;
	use Carbon\Carbon;
	use Livewire\Attributes\On;
	use Livewire\Volt\Component;

	new class extends Component {
		public Subject $subject;
		public Room $room;
		public $startDate;
		public $endDate;
		public array $labels = [];
		public array $data = [];

		public function mount($room):void
		{
			$this->room = $room;
			$this->subject = $room->subject;
			$this->prepareChart();
		}

		public function prepareChart():void
		{
			if ($this->room->subject->callLogs) {
				foreach ($this->room->subject->callLogs->sortByDesc('created_at')->take(10) as $call) {
					$this->labels[] = Carbon::parse($call->ended_at)->setTimezone(config('app.timezone'))->format('D:H:i');
					$this->data[] = $call->duration;
				}
			}
		}

		public function startTimer():void
		{
			$this->dispatch('show-timer');
			$this->startDate = now();
		}

		public function stopTimer():void
		{
			$this->dispatch('stop-timer');
			$this->endDate = now();
		}

		public function clearTimer():void
		{
			$this->startDate = '';
			$this->endDate = '';
			$this->dispatch('reset-timer');
		}

		#[On('time-to-save')]
		public function logCall($durationInSeconds):void
		{
			$newData = $this->room->subject->callLogs()->create([
				'started_at' => $this->startDate,
				'ended_at' => $this->endDate,
				'duration' => $durationInSeconds,
				'negotiation_id' => $this->room->negotiation->id,
				'tenant_id' => $this->room->tenant_id,
				'room_id' => $this->room->id,
				'user_id' => auth()->user()->id
			]);

			$newLabel = Carbon::parse($newData->started_at)->setTimezone(config('app.timezone'))->format('D:H:i');
			$this->dispatch('chartUpdate', $newLabel, $newData->duration);
			$this->dispatch('refreshSubject');
		}
	}

?>

<div
		class="dark:bg-gray-800 bg-white"
		wire:ignore>
	<canvas id="callsChart"></canvas>
	<div class="flex items-center justify-between mt-3 p-2">
		<div class="flex items-center gap-4">
			<x-button
					xs
					positive
					label="Start"
					flat
					wire:click="startTimer">
			</x-button>
			<x-button
					xs
					negative
					label="Stop"
					flat
					wire:click="stopTimer">
			</x-button>
		</div>
		<livewire:timers.chart-timer />
		<div class="">
			<x-button
					xs
					flat
					blue
					label="Save"
					wire:click="$dispatch('save-time')" />
			<x-button
					xs
					flat
					secondary
					label="Clear"
					wire:click="clearTimer" />
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


	const ctx2 = document.getElementById('callsChart')
	if (ctx2) {
		let callsChart = new Chart(ctx2, {
			type: 'line',
			data: {
				labels: @json($labels),
				datasets: [{
					label: 'Call Log Chart',
					data: @json($data),
					borderWidth: 2
				}]
			},
			options: {
				responsive: true,
				plugins: {
					decimation: {},
					title: {
						display: true,
						text: 'Call Log Tracker'
					}
				},
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		})
		window.addEventListener('chartUpdate', event => {
			const { detail: [newLabel, newData] } = event
			addData(newLabel, newData)
		})

		function addData (newLabel, newData) {
			callsChart.data.labels.unshift(newLabel)
			callsChart.data.datasets.forEach((dataset) => {
				dataset.data.unshift(newData)
			})
			if (callsChart.data.labels.length > 5) {
				callsChart.data.labels.pop()
				callsChart.data.datasets.forEach((dataset) => {
					dataset.data.pop()
				})
			}
			callsChart.update()
		}

		window.addEventListener('removeData', removeData)

		function removeData () {
			callsChart.data.labels.unshift()
			callsChart.data.datasets.forEach((dataset) => {
				dataset.data.unshift()
			})

			callsChart.update()
		}
	}
</script>