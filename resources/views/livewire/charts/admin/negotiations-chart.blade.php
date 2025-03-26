<?php

	use App\Models\Negotiation;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $negotiationData;

		public function mount()
		{
			$this->negotiationData = $this->getNegotiationData();
		}

		private function getNegotiationData():array
		{
			$data = [];
			for ($i = 1; $i <= 30; $i++) {
				$date = Carbon::now()->subDays($i - 1)->toDateString();
				$count = Negotiation::whereDate('created_at', $date)->count(); // Use Negotiation model
				$data[$i] = $count;
			}

			return $data;
		}

	}

?>

<div class="bg-[]">
	<canvas
			id="negotiationChart"
			width="400"
			height="200"></canvas>
	<div>

		<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				const negotiationCtx = document.getElementById('negotiationChart').getContext('2d')
				const negotiationData = @json($negotiationData);

				// Prepare data for Chart.js
				const negotiationLabels = Object.keys(negotiationData) // X-axis labels
				const negotiationCounts = Object.values(negotiationData) // Y-axis data

				// Maintain chart type (initially "bar")
				let currentChartType = 'bar'

				// Chart initialization
				let chart = new Chart(negotiationCtx, {
					type: currentChartType,
					data: {
						labels: negotiationLabels,
						datasets: [{
							label: 'New Negotiations (Last 30 Days)',
							data: negotiationCounts,
							borderColor: 'rgb(72, 109, 192)',
							backgroundColor: 'rgba(72, 109, 192, 0.5)', // Bar color
							tension: 0.4 // Line smoothing for line charts
						}]
					},
					options: {
						scales: {
							x: {
								title: {
									display: true,
									text: 'Day'
								}
							},
							y: {
								title: {
									display: true,
									text: 'Number of Negotiations'
								},
								beginAtZero: true // Ensure y-axis starts at 0
							}
						}
					}
				})

				// Event listener for chart type toggle
				const chartToggle = document.getElementById('negotiationToggle')
				chartToggle.addEventListener('change', () => {
					// Update chart type based on toggle state
					currentChartType = chartToggle.checked ? 'line' : 'bar'

					// Destroy the current chart instance
					chart.destroy()

					// Recreate the chart with the new type
					chart = new Chart(negotiationCtx, {
						type: currentChartType,
						data: {
							labels: negotiationLabels,
							datasets: [{
								label: 'New Negotiations (Last 30 Days)',
								data: negotiationCounts,
								borderColor: 'rgb(72, 109, 192)',
								backgroundColor: 'rgba(72, 109, 192, 0.5)',
								tension: 0.4 // Used for smoother lines in the line chart
							}]
						},
						options: {
							scales: {
								x: {
									title: {
										display: true,
										text: 'Day'
									}
								},
								y: {
									title: {
										display: true,
										text: 'Number of Negotiations'
									},
									beginAtZero: true
								}
							}
						}
					})
				})
			})
		</script>
	</div>
</div>
