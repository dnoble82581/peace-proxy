<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $subjectData;
		public int $totals;

		public function mount():void
		{
			$this->subjectData = $this->fetchSubjects();
			$this->totals = $this->fetchTotals();
		}

		private function fetchSubjects():array
		{
			return Subject::query()
				->groupBy('gender')
				->selectRaw('gender, count(*) as count')
				->pluck('count', 'gender')
				->toArray();
		}

		private function fetchTotals():int
		{
			return Subject::count();
		}
	}

?>

<div class="overflow-hidden rounded-lg">
	<div class="px-4 py-2 sm:p-3 border-b border-gray-500">
		<p class="text-white text-sm font-semibold">Subjects Count</p>
	</div>
	<div class="px-4 py-4 sm:px-6">
		@foreach ($subjectData as $gender => $count)
			<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
				<span>{{ $gender }}</span>
				<span>{{ $count }}</span>
			</div>
		@endforeach
	</div>
	<div class="flex justify-between px-4 py-2 text-sm sm:px-6 bg-[#2e2e2e] text-[#dddddd]">
		<span>Total:</span>
		<span>{{ $totals }}</span>
	</div>
</div>
