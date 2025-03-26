<?php

	use App\Models\Negotiation;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public $resolutionCounts;

		public function mount()
		{
			$this->resolutionCounts = $this->getResolutionCounts();
		}


		//updated lifecycle hook
		public function updated($propertyName)
		{
			if ($propertyName === 'resolutionCounts') {
				$this->dispatch('chartDataUpdated', [
					'resolutionCounts' => $this->resolutionCounts
				]);
			}
		}

		private function getResolutionCounts()
		{
			return Negotiation::groupBy('resolution') // Replace 'resolution_type'
			->selectRaw('resolution, count(*) as count')
				->pluck('count', 'resolution') // resolution_type as key
				->toArray();

		}

	}


?>

<div>
	<canvas
			id="resolutionChart"
			width="400"
			height="200"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', () => {
		let resolutionChart

		const resolutionCtx = document.getElementById('resolutionChart').getContext('2d')
		const resolutionData = @json($resolutionCounts);

		// Prepare data
		const resolutionLabels = Object.keys(resolutionData)
		const resolutionCounts = Object.values(resolutionData)

		// Initial chart type
		let currentChartType = 'bar'

		// Chart initialization function
		function createChart (chartType) {
			return new Chart(resolutionCtx, {
				type: chartType,
				data: {
					labels: resolutionLabels,
					datasets: [{
						label: 'Resolution Counts',
						data: resolutionCounts,
						borderColor: 'rgb(241, 97, 148)',
						backgroundColor: 'rgb(97, 242,259)',
						tension: 0.4
					}]
				},
				options: {
					scales: chartType === 'bar'
						? {
							y: {
								beginAtZero: true
							}
						}
						: {}
				}
			})
		}

		// Create the initial chart
		resolutionChart = createChart(currentChartType)

		// Toggle switch functionality
		const chartToggle = document.getElementById('resolutionToggle')
		chartToggle.addEventListener('change', () => {
			// Update current chart type based on the toggle
			currentChartType = chartToggle.checked ? 'line' : 'bar'

			// Destroy the current chart
			resolutionChart.destroy()

			// Recreate the chart with the new type
			resolutionChart = createChart(currentChartType)
		})
	})
</script>



