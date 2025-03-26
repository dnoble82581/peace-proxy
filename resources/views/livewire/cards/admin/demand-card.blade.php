<?php

	use App\Models\Demand;
	use App\Models\Negotiation;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $demandData;
		public int $totals;

		public function mount()
		{
			$this->demandData = $this->fetchDemands();
			$this->totals = $this->fetchTotal();
		}

		private function fetchDemands()
		{
			return Demand::query()
				->groupBy('type')
				->selectRaw('type, count(*) as count')
				->pluck('count', 'type')
				->toArray();
		}

		private function fetchTotal():int
		{
			return Demand::count();
		}
	}

?>


<div class="overflow-hidden rounded-lg">
	<div class="px-4 py-2 sm:p-3 border-b border-gray-500">
		<p class="text-white text-sm font-semibold">Demands Count</p>
	</div>
	<div class="px-4 py-4 sm:px-6">
		@foreach ($demandData as $type => $count)
			<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
				<span>{{ $type }}</span>
				<span>{{ $count }}</span>
			</div>
		@endforeach
	</div>
	<div class="flex justify-between px-4 py-2 text-sm sm:px-6 bg-[#2e2e2e] text-[#dddddd]">
		<span>Total:</span>
		<span>{{ $totals }}</span>
	</div>
</div>

