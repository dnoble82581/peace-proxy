<?php

	use App\Models\RiskAssessmentQuestion;
	use App\Traits\Searchable;
	use Illuminate\Database\Eloquent\Collection;
	use Livewire\Volt\Component;

	new class extends Component {

		public array $questions;
		public string $searchTerm = '';
		public int $totalCount;


		public function mount():void
		{
			$this->questions = $this->fetchQuestions();
			$this->totalCount = $this->fetchTotalCount();
		}

		private function fetchTotalCount():int
		{
			return RiskAssessmentQuestion::count();
		}

		private function fetchQuestions():array
		{
			return RiskAssessmentQuestion::query()
				->when($this->searchTerm, function ($query) {
					$query->where('question_text', 'like', '%'.$this->searchTerm.'%')
						->orWhere('type', 'like', '%'.$this->searchTerm.'%');
				})
				->select(['id', 'question_text', 'type'])
				->pluck('type', 'question_text') // Use pluck to keep the structure
				->toArray();
		}

		public function updatedSearchTerm():void // Triggered when the search term updates
		{
			$this->questions = $this->fetchQuestions();
		}


	}

?>


<div class="overflow-hidden rounded-lg">
	<div class="px-4 py-2 sm:p-3 border-b border-gray-500 flex justify-between items-center">
		<p class="text-white text-sm font-semibold h-7">Risk Assessment Questions</p>
		<x-form-elements.comoponent-search field="searchTerm" />
	</div>
	<div class="px-4 py-4 sm:px-6 h-60 overflow-y-auto">
		@foreach ($questions as $question_text => $type)
			<div class="flex text-[#dddddd] py-2 px-2 border-b border-b-gray-300 items-center justify-between text-sm">
				<span class="truncate">{{ $question_text }}</span>
				<span>{{ $type }}</span>
			</div>
		@endforeach
	</div>
	<div class="flex justify-between px-4 py-2 text-sm sm:px-6 bg-[#2e2e2e] text-[#dddddd]">
		<span>Count:</span>
		<span>{{ $totalCount }}</span>
	</div>
</div>
