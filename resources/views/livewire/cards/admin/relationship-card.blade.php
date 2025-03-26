<?php

	use App\Models\AssociateRelationship;
	use Livewire\Volt\Component;

	new class extends Component {
		public array $relationships;
		public int $totals;
		public string $searchRelationship = '';

		public function mount()
		{
			$this->relationships = $this->fetchRelationships();
			$this->totals = $this->fetchTotals();
		}

		private function fetchTotals()
		{
			return AssociateRelationship::count();
		}

		public function updatedSearchRelationship()
		{
			$this->relationships = $this->fetchRelationships();
		}

		private function fetchRelationships()
		{
			return AssociateRelationship::query()
				->when($this->searchRelationship, function ($query) {
					$query->where('relationship', 'like', '%'.$this->searchRelationship.'%');
				})
				->select(['id', 'relationship'])
				->pluck('relationship')
				->toArray();
		}
	}

?>


<div class="overflow-hidden rounded-lg">
	<div class="px-4 py-2 sm:p-3 border-b border-gray-500 flex justify-between items-center">
		<p class="text-white text-sm font-semibold h-7">Associate Relationships</p>
		<x-form-elements.comoponent-search field="searchRelationship" />
	</div>
	<div class="px-4 py-4 sm:px-6 h-60 overflow-y-auto">
		@foreach ($relationships as $relationship)
			<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
				<span>{{ $relationship }}</span>
			</div>
		@endforeach
	</div>
	<div class="flex justify-between px-4 py-2 text-sm sm:px-6 bg-[#2e2e2e] text-[#dddddd]">
		<span>Total:</span>
		<span>{{ $totals }}</span>
	</div>
</div>
