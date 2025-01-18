<?php

	use App\Models\Subject;
	use App\Models\Warrant;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {
		public Subject $subject;
		public Warrant $warrant;

		public function mount(Subject $subject):void
		{
			$this->subject = $subject;
		}

		private function getSubject($subjectId):Subject
		{
			return Subject::findOrFail($subjectId);
		}

		public function deleteWarrant($warrantId):void
		{
			$this->warrant = $this->getWarrant($warrantId);
			$this->warrant->delete();
		}

		public function editWarrant($warrantID)
		{
			$this->dispatch('modal.open', component: 'modals.edit-warrant-form',
				arguments: [$warrantID]);
		}

		private function getWarrant($warrantId):Warrant
		{
			return Warrant::findOrFail($warrantId);
		}

		public function getListeners()
		{
			return [
				"echo-presence:warrant.{$this->subject->room_id},WarrantEditedEvent" => 'refresh',
			];
		}

	}

?>

<div class="px-4 sm:px-6 lg:px-8">
	<div class="flex justify-end px-4 mt-2">
		<button wire:click="addWarning">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="mt-3 flow-root">
		<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				@if($subject->warrants->count())
					<x-table-elements.subject-card-table-layout
							:labels="['Offense', 'Originating County', 'Originating State', 'Extraditable', 'Action']">
						@foreach($subject->warrants as $warrant)
							<a href="#">
								<x-table-elements.subject-warrants-row :warrant="$warrant" />
							</a>
						@endforeach
					</x-table-elements.subject-card-table-layout>
				@else
					<div class="h-full">
						<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Warrants</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
