<?php

	use App\Models\Negotiation;
	use App\Models\Tenant;
	use App\Models\User;
	use App\Services\RecordRetrievalService;
	use App\Traits\ChangePercentageCalculator;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Support\Collection;
	use Livewire\Volt\Component;

	new class extends Component {

		public Collection $users;
		public Tenant $tenant;
		public float $userPercentChange;
		public float $negotiationPercentChange;
		public Collection $recentNegotiations;
		public Collection $negotiatedSurrender;
		public float $negotiatedSurrenderPercentage;


		public function mount()
		{
			$this->users = $this->fetchRecentUsers();
			$this->tenant = auth()->user()->tenant;
			$this->userPercentChange = $this->calculateUserChange();
			$this->recentNegotiations = $this->fetchRecentNegotiations();
			$this->negotiationPercentChange = $this->calculateNegotiationChange();
			$this->negotiatedSurrender = $this->fetchNegotiatedSurrender();
			$this->negotiatedSurrenderPercentage = $this->calculateNegotiatedSurrenderPercentage();

		}

		private function fetchRecentUsers()
		{
			$recordRetrievalService = new RecordRetrievalService();
			return $recordRetrievalService
				->getRecordsWithinTimeFrame(User::query(), 30)
				->get();
		}

		private function fetchNegotiatedSurrender()
		{
			$recordRetrievalService = new RecordRetrievalService();
			$records = $recordRetrievalService->getRecordsWithinTimeFrame(Negotiation::query(), 30);
			return $records->where('resolution', 'Negotiated Surrender')->get();
		}

		private function fetchRecentNegotiations()
		{
			$recordRetrievalService = new RecordRetrievalService();
			return $recordRetrievalService
				->getRecordsWithinTimeFrame(Negotiation::query(), 30)
				->get();
		}

		private function calculateNegotiatedSurrenderPercentage():float
		{
			$totalNegotiations = $this->tenant->negotiations()->count(); // Get total negotiations for the tenant
			$negotiatedSurrenderCount = $this->tenant->negotiations()
				->where('resolution', 'Negotiated Surrender')
				->count(); // Count 'Negotiated Surrender' resolutions

			if ($totalNegotiations === 0) {
				return 0.0; // Avoid division by zero
			}

			// Calculate the percentage
			$percentage = ($negotiatedSurrenderCount / $totalNegotiations) * 100;

			return round($percentage, 2); // Return the percentage rounded to 2 decimal places
		}


		private function calculateUserChange()
		{
			return $this->tenant->calculatePercentageChange($this->tenant->users());
		}

		private function calculateNegotiationChange()
		{
			return $this->tenant->calculatePercentageChange($this->tenant->negotiations());
		}
	}

?>

<div class="col-span-full mt-8 sm:mt-0">
	<h3 class="text-base font-semibold text-gray-900">Last 30 days</h3>

	<dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
		<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
			<dt>
				<div class="absolute rounded-md bg-indigo-500 p-3">
					<svg
							class="size-6 text-white"
							fill="none"
							viewBox="0 0 24 24"
							stroke-width="1.5"
							stroke="currentColor"
							aria-hidden="true"
							data-slot="icon">
						<path
								stroke-linecap="round"
								stroke-linejoin="round"
								d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
					</svg>
				</div>
				<p class="ml-16 truncate text-sm font-medium text-gray-500">New Team Members</p>
			</dt>
			<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
				<p class="text-2xl font-semibold text-gray-900">{{ $this->users->count() }}</p>
				<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
					<x-heroicons::micro.solid.arrow-long-up class="shrink-0 self-center text-green-500" />
					<span class="sr-only"> Increased by </span>
					{{ $this->userPercentChange }}%
				</p>
				<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
					<div class="text-sm">
						<a
								href="#"
								class="font-medium text-indigo-600 hover:text-indigo-500">View
						                                                                  all<span class="sr-only"> Total Subscribers stats</span></a>
					</div>
				</div>
			</dd>
		</div>
		<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
			<dt>
				<div class="absolute rounded-md bg-indigo-500 p-3">
					<x-heroicons::micro.solid.arrow-trending-up class="size-6 text-white" />
				</div>
				<p class="ml-16 truncate text-sm font-medium text-gray-500">New Negotiations</p>
			</dt>
			<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
				<p class="text-2xl font-semibold text-gray-900">{{ $this->recentNegotiations->count() }}</p>
				<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">
					<x-heroicons::micro.solid.arrow-long-up class="shrink-0 self-center text-green-500" />
					<span class="sr-only"> Increased by </span>
					{{ $this->negotiationPercentChange }}%
				</p>
				<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
					<div class="text-sm">
						<a
								href="#"
								class="font-medium text-indigo-600 hover:text-indigo-500">View
						                                                                  all<span class="sr-only"> Avg. Open Rate stats</span></a>
					</div>
				</div>
			</dd>
		</div>
		<div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 pb-12 shadow-sm sm:px-6 sm:pt-6">
			<dt>
				<div class="absolute rounded-md bg-indigo-500 p-3">
					<x-heroicons::outline.newspaper class="size-6 text-white" />
				</div>
				<p class="ml-16 truncate text-sm font-medium text-gray-500">Negotiated Surrender</p>
			</dt>
			<dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
				<p class="text-2xl font-semibold text-gray-900">{{ $this->negotiatedSurrender->count() }}</p>
				<p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">

					{{ $this->negotiatedSurrenderPercentage }}%
				</p>
				<div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
					<div class="text-sm">
						<a
								href="#"
								class="font-medium text-indigo-600 hover:text-indigo-500">View
						                                                                  all<span class="sr-only"> Avg. Click Rate stats</span></a>
					</div>
				</div>
			</dd>
		</div>
	</dl>
</div>
