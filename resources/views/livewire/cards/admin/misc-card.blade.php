<?php

	use Illuminate\Database\Eloquent\Model;
	use Livewire\Volt\Component;

	new class extends Component {
		public int $triggers;
		public int $hooks;
		public int $associates;
		public int $totals;

		public function mount()
		{
			$this->triggers = $this->fetchData(new App\Models\Trigger());
			$this->hooks = $this->fetchData(new App\Models\Hook());
			$this->associates = $this->fetchData(new App\Models\Associate());
			$this->totals = $this->fetchTotals();
		}

		private function fetchData(Model $model)
		{
			return $model::count();
		}

		private function fetchTotals()
		{
			return $this->triggers + $this->hooks + $this->associates;
		}
	}

?>

<div class="overflow-hidden rounded-lg">
	<div class="px-4 py-2 sm:p-3 border-b border-gray-500">
		<p class="text-white text-sm font-semibold">Misc</p>
	</div>
	<div class="px-4 py-4 sm:px-6">
		<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
			<span>Triggers</span>
			<span>{{ $triggers }}</span>
		</div>
		<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
			<span>Hooks</span>
			<span>{{ $hooks }}</span>
		</div>
		<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
			<span>Associates</span>
			<span>{{ $associates }}</span>
		</div>
	</div>
	<div class="flex justify-between px-4 py-2 text-sm sm:px-6 bg-[#2e2e2e] text-[#dddddd]">
		<span>Total:</span>
		<span>{{ $totals }}</span>
	</div>
</div>