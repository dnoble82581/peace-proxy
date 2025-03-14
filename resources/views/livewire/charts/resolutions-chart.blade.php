<?php

	use App\Models\ResolutionResponse;
	use App\Models\Tenant;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $labels;
		public array $data;
		public Tenant $tenant;

		public function mount()
		{
			$this->tenant = auth()->user()->tenant;
			$this->fetchResolutionOptionsData();
		}

		private function fetchResolutionOptionsData():void
		{
			// Count how many times each resolution response (option) is selected
			$optionCounts = DB::table('negotiations')
				->select('resolution', DB::raw('COUNT(id) as count'))
				->where('tenant_id', $this->tenant->id)
				->groupBy('resolution')
				->orderBy('count', 'DESC')
				->pluck('count', 'resolution');


			// Convert the result into specific labels and values for Chart.js
			$this->labels = $optionCounts->keys()->toArray();      // Option labels
			$this->data = $optionCounts->values()->toArray();     // Number of times each option was selected

		}
	}
?>
<div class="col-span-3">
	<!-- Pie Chart Container -->
	<canvas
			id="resolutionOptionsChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function () {
		// Get data from Livewire or backend
		const labels = @json($labels); // Labels (responses)
		const data = @json($data);   // Data (counts)

		const ctx = document.getElementById('resolutionOptionsChart').getContext('2d')
		new Chart(ctx, {
			type: 'line', // Pie chart type
			data: {
				labels: labels, // Option labels
				datasets: [{
					label: 'Resolution Responses',
					data: data, // Option counts
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)'
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						display: true,
						position: 'top'
					},
					tooltip: {
						callbacks: {
							label: function (tooltipItem) {
								const label = labels[tooltipItem.dataIndex]
								const value = data[tooltipItem.dataIndex]
								return `${label}: ${value}`
							}
						}
					}
				}
			}
		})
	})
</script>

