<?php

	use App\Models\User;
	use Carbon\Carbon;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $userData;

		public function mount()
		{
			$this->userData = $this->getUserData();
		}


		private function getUserData():array
		{
			$data = [];
			for ($i = 1; $i <= 30; $i++) { // Start from 1, go up to and including 30
				$date = Carbon::now()->subDays($i - 1)->toDateString(); // Subtract $i - 1
				$count = User::whereDate('created_at', $date)->count();
				$data[$i] = $count; // Use $i as the key
			}
			return $data;
		}

	}

?>
<div>
	<canvas
			id="userChart"
			width="400"
			height="200"></canvas>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// JavaScript for Chart.js
		document.addEventListener('DOMContentLoaded', () => {
			const userCtx = document.getElementById('userChart').getContext('2d')
			const userData = @json($userData);  // Pass PHP data to JS

			// Prepare data for Chart.js
			const userLabels = Object.keys(userData) // X-axis labels
			const userCounts = Object.values(userData) // Y-axis data

			// Maintain chart type (initially "line")
			let currentChartType = 'line'

			// Chart initialization
			let chart = new Chart(userCtx, {
				type: currentChartType,
				data: {
					labels: userLabels,
					datasets: [{
						label: 'New Users (Last 30 Days)',
						data: userCounts,
						borderColor: 'rgb(75, 192, 192)',
						backgroundColor: 'rgba(75, 192, 192, 0.5)', // Bar color
						tension: 0.4 // Line smoothing
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
								text: 'Number of Users'
							},
							beginAtZero: true // Ensure y-axis starts at 0
						}
					}
				}
			})

			// Add event listener for the toggle button
			const toggleBtn = document.getElementById('toggleChartTypeButton')
			toggleBtn.addEventListener('click', () => {
				// Toggle chart type
				currentChartType = currentChartType === 'line' ? 'bar' : 'line'

				// Destroy the current chart instance
				chart.destroy()

				// Recreate the chart with the new type
				chart = new Chart(userCtx, {
					type: currentChartType,
					data: {
						labels: userLabels,
						datasets: [{
							label: 'New Users (Last 30 Days)',
							data: userCounts,
							borderColor: 'rgb(75, 192, 192)',
							backgroundColor: 'rgba(75, 192, 192, 0.5)',
							tension: 0.4
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
									text: 'Number of Users'
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
