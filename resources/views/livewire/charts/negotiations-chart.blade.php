<?php

	use App\Models\Negotiation;
	use App\Models\User;
	use Carbon\Carbon;
	use Carbon\CarbonPeriod;
	use Livewire\Attributes\On;
	use Livewire\Volt\Component;

	new class extends Component {

		public array $labels;
		public array $data;

		public function mount()
		{
			$this->labels = $this->fetchMonths();
			$this->data = $this->fetchNegotiationCounts();
		}

		private function fetchMonths():array
		{
			$months = [];
			for ($m = 1; $m <= 12; $m++) {
				$months[] = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
			}
			return $months;
		}

		private function fetchNegotiationCounts():array
		{
			$year = date('Y'); // Current year

			// Initialize an array to store negotiations count for each month
			$counts = array_fill(0, 12, 0);

			// Query the Negotiation model to count per month
			$negotiations = Negotiation::query()
				->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
				->whereYear('created_at', $year)
				->groupBy('month')
				->pluck('count', 'month');

			// Map the result to the $counts array
			foreach ($negotiations as $month => $count) {
				$counts[$month - 1] = $count; // Convert 1-indexed month to 0-indexed
			}

			return $counts;
		}

	}

?>

<div class="col-span-3">
	<canvas
			wire:ignore.self
			id="negotiationsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Data from backend
		const labels = @json($labels); // Month labels
		const data = @json($data); // Negotiations data

		const ctx = document.getElementById('negotiationsChart').getContext('2d')

		// Initial chart type
		let currentChartType = 'bar'

		// Initialize Chart.js instance
		let negotiationsChart = new Chart(ctx, {
			type: currentChartType,
			data: {
				labels: labels,
				datasets: [{
					label: 'Negotiations Created',
					data: data,
					backgroundColor: 'rgba(54, 162, 235, 0.2)',
					borderColor: 'rgba(54, 162, 235, 1)',
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				scales: {
					y: {
						beginAtZero: true,
						title: {
							display: true,
							text: 'Number of Negotiations'
						}
					},
					x: {
						title: {
							display: true,
							text: 'Months'
						}
					}
				}
			}
		})

		// Handle chart type switching
		document.getElementById('chartTypeSelector').addEventListener('change', function (event) {
			// Get the selected chart type from the dropdown
			currentChartType = event.target.value

			// Destroy the existing chart instance
			negotiationsChart.destroy()

			// Reinitialize the chart with the new type
			negotiationsChart = new Chart(ctx, {
				type: currentChartType,
				data: {
					labels: labels,
					datasets: [{
						label: 'Negotiations Created',
						data: data,
						backgroundColor: currentChartType === 'bar' ? 'rgba(54, 162, 235, 0.2)' : 'transparent',
						borderColor: 'rgba(54, 162, 235, 1)',
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					scales: {
						y: {
							beginAtZero: true,
							title: {
								display: true,
								text: 'Number of Negotiations'
							}
						},
						x: {
							title: {
								display: true,
								text: 'Months'
							}
						}
					}
				}
			})
		})
	})
</script>


