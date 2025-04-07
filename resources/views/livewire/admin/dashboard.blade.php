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
	<div class="bg-[#1a1a1b] p-4 rounded-md">
		<form action="">
			<div class="grid grid-cols-12 gap-4">
				<div class="relative col-span-6">
					<x-input

							id="search"
							icon="magnifying-glass">
						<x-slot
								name="label"
								class="text-white font-semibold mb-1">
							Search
						</x-slot>
					</x-input>
				</div>

				<div class="gap-2 col-span-6 flex mt-7">
					<x-buttons.admin.filter-button value="Daily" />
					<x-buttons.admin.filter-button value="Weekly" />
					<x-buttons.admin.filter-button value="Monthly" />
					<x-buttons.admin.filter-button value="Custom" />
					<x-buttons.admin.filter-button
							bgColor="bg-indigo-500"
							value="Reset Filters" />
				</div>
			</div>
		</form>
	</div>
	<div class="grid grid-cols-12 gap-4 mt-4">
		<div
				class="col-span-4 bg-[#1a1a1b] rounded-md p-4 relative">
			<livewire:charts.admin.users-chart
					id="usersChartCanvas"
					:data="$userData" />
			<span class="absolute top-3 right-3">
				<x-toggle id="toggleChartTypeButton" />
			</span>
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-md p-4 relative">
			<livewire:charts.admin.negotiations-chart id="negotiationsChartCanvas" />
			<span class="absolute top-3 right-3">
				<x-toggle
						id="negotiationToggle"
						name="toggle"
						xs />
			</span>
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-md p-4 relative">
			<livewire:charts.admin.resolution-chart id="resolutionChartCanvas" />
			<span class="absolute top-3 right-3">
				<x-toggle
						id="resolutionToggle"
						name="toggle"
						xs />
			</span>
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-lg">
			<livewire:cards.admin.demand-card />
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-lg">
			<livewire:cards.admin.subjects-card />
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-lg">
			<livewire:cards.admin.misc-card />
		</div>
		<div class="col-span-8 bg-[#1a1a1b] rounded-lg">
			<livewire:cards.admin.risk-assessment-questions />
		</div>
		<div class="col-span-4 bg-[#1a1a1b] rounded-lg">
			<livewire:cards.admin.relationship-card />
		</div>
	</div>
	
</div>
