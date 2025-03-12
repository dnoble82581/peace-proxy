<?php

	use App\Events\DocumentDeletedEvent;
	use App\Models\Document;
	use App\Models\Negotiation;
	use App\Models\Subject;
	use App\Models\Tenant;
	use App\Models\User;
	use App\Services\DocumentProcessor;
	use Livewire\Volt\Component;
	use WireElements\Pro\Concerns\InteractsWithConfirmationModal;


	new class extends Component {
		use InteractsWithConfirmationModal;

		public Negotiation $negotiation;
		public Subject $subject;

		public function createForm():void
		{
			$this->dispatch('modal.open', component: 'modals.create-resolution-form',
				arguments: ['negotiationId' => $this->negotiation->id, 'subjectId' => $this->subject->id]);
		}
		
		public function getListeners():array
		{
			return [
				"echo-presence:document.{$this->subject->room_id},DocumentDeletedEvent" => 'refresh',
				"echo-presence:document.{$this->subject->room_id},DocumentCreatedEvent" => 'refresh',
			];
		}

		public function mount($negotiationId, $subjectId):void
		{
			$this->negotiation = Negotiation::findOrFail($negotiationId);
			$this->subject = Subject::findOrFail($subjectId);
		}

		public function downloadDocument(Document $document)
		{
			$documentProcessor = new DocumentProcessor(); // Or inject it via dependency injection
			try {
				return $documentProcessor->downloadDocument(
					$document->documentable,
					$document->filename
				);
			} catch (Exception $e) {
				abort(404, $e->getMessage());
			}
		}

		public function deleteDocument($documentId)
		{
			$documentToDelete = Document::findOrFail($documentId);
			$documentProcessor = new DocumentProcessor();

			try {
				// Delegate deletion to DocumentProcessor
				$isDeleted = $documentProcessor->deleteDocument(
					$this->negotiation,
					$documentToDelete->filename
				);

				// Feedback to the user
				if ($isDeleted) {
					$this->flashMessage = 'Document successfully deleted.';
				} else {
					$this->flashMessage = 'Failed to delete the document.';
				}

				// Dispatch event after successful deletion
				event(new DocumentDeletedEvent($documentToDelete->id, $this->subject->room_id));
			} catch (Exception $e) {
				// Handle deletion errors
				$this->flashMessage = 'Error: '.$e->getMessage();
			}
		}
	}

?>

<div class="px-2">
	<div class="flex justify-end px-4">
		<x-dropdown.dropdown>
			<x-slot:trigger>
				<button type="button">
					<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
				</button>
			</x-slot:trigger>
			<x-slot:content>
				<x-dropdown.dropdown-button wire:click="createForm">
					Resolution
				</x-dropdown.dropdown-button>
			</x-slot:content>
		</x-dropdown.dropdown>
	</div>
	<ul
			role="list"
			class="divide-y divide-gray-100">
		@if($negotiation->documents->count())
			<x-table-elements.subject-card-table-layout :labels="['File Name', 'Type', 'Size', 'Created At', 'Actions' ]">
				<x-slot:content>
					@foreach($negotiation->documents as $document)
						<tr class="even:bg-gray-50 dark:even:bg-slate-900">
							<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap dark-light-text sm:pl-3">
								{{ $document->filename }}
							</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $document->type }}</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ round($document->size/1000) }}
								kb
							</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap dark-light-text">{{ $document->created_at->diffForHumans() }}
							</td>
							<td class="relative py-2 gap-3 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3 flex">
								<a
										href="{{ $document->privateUrl() }}"
										target="_blank">
									<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
								</a>
								<button
										type="button"
										wire:click="deleteDocument({{ $document->id}})">
									<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
								</button>
								<button
										type="button"
										wire:click="downloadDocument({{ $document->id }})">
									<x-heroicons::outline.arrow-down-tray class="w-4 h-4 hover:text-slate-500 text-slate-400 cursor-pointer" />
								</button>
							</td>
						</tr>
					@endforeach
				</x-slot:content>

			</x-table-elements.subject-card-table-layout>
		@else
			<div class="h-full">
				<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Documents</h3>
			</div>
		@endif
	</ul>
</div>
