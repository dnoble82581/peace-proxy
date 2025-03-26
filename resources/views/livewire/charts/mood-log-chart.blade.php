<?php

	use App\Events\ChartUpdatedEvent;
	use App\Models\Room;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public Room $room;
		public array $moodLabels = [];
		public array $moodData = [];

		public function mount(Room $room):void
		{
			$this->room = $room;
			$this->prepareChart();
		}

		/**
		 * Logs a mood, saves it in the database, and dispatches events.
		 */
		public function logMood(int $mood, string $name):void
		{
			try {
				$newMood = $this->room->subject->moodLogs()->create([
					'time' => now(),
					'mood' => $mood,
					'name' => $name,
					'user_id' => auth()->user()->id,
					'subject_id' => $this->room->subject->id,
					'negotiation_id' => $this->room->negotiation->id,
					'room_id' => $this->room->id,
					'tenant_id' => $this->room->tenant_id,
				]);

				// Dispatch frontend events
				$this->dispatch('refreshSubject');
				$this->dispatch('moodUpdate', $this->formatTimestamp($newMood->created_at), $newMood->mood);
				event(new ChartUpdatedEvent($this->room->id, $newMood->id));
			} catch (Exception $e) {
				logger('Failed to log mood: '.$e->getMessage());
			}
		}

		/**
		 * Prepares mood chart data.
		 */
		public function prepareChart():void
		{
			$recentMoodLogs = $this->room->subject->moodLogs()
				->latest('created_at')
				->take(10)
				->get();

			$this->moodLabels = $recentMoodLogs->map(fn($mood) => $this->formatTimestamp($mood->created_at))->toArray();
			$this->moodData = $recentMoodLogs->pluck('mood')->toArray();

			if (empty($this->moodLabels) || empty($this->moodData)) {
				logger('Mood chart data is empty. No mood logs available.');
			}
		}

		/**
		 * Formats a timestamp for chart labels.
		 */
		private function formatTimestamp(Carbon $timestamp):string
		{
			return $timestamp->setTimezone(config('app.timezone'))->format('D:H:i');
		}
	};

?>


		<!-- Frontend Markup -->
<div
		wire:ignore
		class="bg-white dark:bg-gray-800 px-10">
	<!-- Chart Canvas -->
	<canvas id="moodChart"></canvas>

	<!-- Mood Logging Buttons -->
	<div class="p-4 flex justify-between">
		@foreach (App\Enums\MoodsList::cases() as $mood)
			<button
					title="{{ $mood->description() }}"
					class="hover:-translate-y-1 transition-all duration-300 ease-in-out">
				<x-dynamic-component
						wire:click="logMood({{ $mood->numericValue() }}, '{{ $mood->value }}')"
						:component="$mood->emoji()"
						class="w-8 h-8" />
			</button>
		@endforeach
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	const ctx = document.getElementById('moodChart')
	if (ctx) {
		// Initializes a new Chart.js line chart1
		let moodChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: @json($moodLabels), // X-axis labels (timestamps)
				datasets: [{
					label: 'Mood Point', // Dataset label
					data: @json($moodData), // Y-axis data (mood scores)
					borderWidth: 1,
					borderColor: 'rgba(45, 212, 191, 1)', // Line color (Blue in this example)
					backgroundColor: 'rgba(54, 162, 235, 0.2)', // Optional: Fill color under the line (transparent blue)
				}]
			},
			options: {
				responsive: true, // Adjust chart size to container
				plugins: {
					title: {
						display: true,
						text: 'Mood Log Tracker' // Chart title
					}
				},
				scales: {
					y: {
						beginAtZero: true, // Start y-axis at 0
					}
				}
			}
		})

		// Listen for mood update events
		window.addEventListener('moodUpdate', event => {
			const { detail: [newLabel, newData] } = event

			addMood(moodChart, newLabel, newData) // Add updated mood to the chart
		})

		/**
		 * Updates the chart with a new data point.
		 *
		 * @param {Object} chart - The Chart.js instance
		 * @param {string} newLabel - New label for the x-axis
		 * @param {number} newData - New data point for the y-axis
		 */
		function addMood (chart, newLabel, newData) {
			if (newLabel == null || newData == null) { // Validate data
				console.error('Invalid mood update data:', { label: newLabel, data: newData })
				return
			}

			// Add new data point and label to the beginning of the chart
			chart.data.labels.unshift(newLabel)
			chart.data.datasets.forEach((dataset) => {
				dataset.data.unshift(newData)
			})

			// Limit chart to 5 data points
			if (chart.data.labels.length > 5) {
				chart.data.labels.pop() // Remove the oldest label
				chart.data.datasets.forEach((dataset) => {
					dataset.data.pop() // Remove the oldest data point
				})
			}

			chart.update() // Redraw the chart
		}
	}
</script>