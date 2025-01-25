<?php

	use App\Events\WarrantDeletedEvent;
	use App\Livewire\Forms\WarrantForm;
	use App\Models\Subject;
	use App\Models\Warrant;
	use Livewire\Volt\Component;

	new class extends Component {
		public Subject $subject;
		public Warrant $warrant;
		public WarrantForm $form;

		public function mount(Subject $subject):void
		{
			$this->subject = $subject->load('warrants');
		}

		private function getSubject($subjectId):Subject
		{
			return Subject::findOrFail($subjectId);
		}

		public function deleteWarrant($warrantId):void
		{
			$this->warrant = $this->getWarrant($warrantId);
			$this->warrant->delete();
			event(new WarrantDeletedEvent($this->subject->id));
		}

		public function editWarrant($warrantId):void
		{
			$this->dispatch('modal.open', component: 'modals.edit-warrant-form',
				arguments: [$warrantId]);
		}

		public function addWarrant()
		{
			$this->dispatch('modal.open', component: 'modals.create-warrant-form',
				arguments: [$this->subject->id]);
		}

		public function showWarrant($warrantId)
		{
			$this->dispatch('modal.open', component: 'modals.show-warrant',
				arguments: [$warrantId]);
		}

		private function getWarrant($warrantId):Warrant
		{
			return Warrant::findOrFail($warrantId);
		}

		public function getListeners()
		{
			return [
				"echo-presence:warrant.{$this->subject->room_id},WarrantEditedEvent" => 'refresh',
				"echo-presence:warrant.{$this->subject->room_id},WarrantCreatedEvent" => 'refresh',
				"echo-presence:warrant.{$this->subject->room_id},WarrantDeletedEvent" => 'refresh',
			];
		}

	}

?>

<div class="px-2">
	<div class="flex justify-end px-4">
		<button
				type="button"
				wire:click="addWarrant()">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="flow-root">
		<div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				<x-table-elements.subject-card-table-layout :labels="['Offense', 'Agency', 'Extraditable','Confirmed','Actions']">
					<x-slot:content>
						@foreach ($this->subject->warrants as $warrant)
							<tr class="even:bg-gray-50 dark:even:bg-slate-900">
								<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap dark-light-text sm:pl-3">
									{{ $warrant->offense }}
								</td>
								<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $warrant->originating_agency }}</td>
								<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $warrant->extraditable }}
								<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $warrant->confirmed }}
								</td>
								<td class="relative py-2 space-x-2 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3">
									<button
											type="button"
											wire:click="showWarrant({{ $warrant->id }})">
										<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
									</button>
									<button
											type="button"
											wire:click="editWarrant({{ $warrant->id }})">
										<x-heroicons::mini.solid.pencil-square class="w-4 h-4 hover:text-blue-500 text-blue-400 cursor-pointer" />
									</button>
									<button
											type="button"
											wire:click="deleteWarrant({{ $warrant->id }})">
										<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
									</button>
								</td>
							</tr>
						@endforeach
					</x-slot:content>
				</x-table-elements.subject-card-table-layout>
			</div>
		</div>
	</div>
</div>
