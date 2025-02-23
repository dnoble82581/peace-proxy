<?php

	use App\Events\DocumentDeletedEvent;
	use App\Models\Document;
	use App\Models\Subject;
	use App\Services\DocumentProcessor;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {

		public string $flashMessage = 'Some message';


		public Subject $subject;

		public function mount($subject)
		{
			$this->subject = $subject;
		}

		public function createForm()
		{
			$this->dispatch('modal.open', component: 'modals.forms.on-scene-risk-assessment',
				arguments: ['subjectId' => $this->subject->id]);
		}

		public function downloadDocument(Document $document)
		{
			$filePath = '/documents/'.strtolower(class_basename($document->documentable)).'/'.$document->documentable_id.'/'.$document->filename;

			if (Storage::disk('s3')->exists($filePath)) {
				return Storage::disk('s3')->download($filePath, $document->filename);
			}

			abort(404, 'Document not found');

		}

		public function deleteDocument($documentId)
		{
			$documentToDelete = Document::findOrFail($documentId);
			$documentProcessor = new DocumentProcessor;
			try {
				$isDeleted = $documentProcessor->deleteDocument($this->subject,
					$documentToDelete->filename);
				if ($isDeleted) {
					$this->flashMessage = 'Document successfully deleted.';
				} else {
					$this->flashMessage = 'Failed to delete the document.';
				}
			} catch (Exception $e) {
				echo 'Error: '.$e->getMessage();
			}
			event(new DocumentDeletedEvent($documentToDelete->id, $this->subject->room_id));
		}

		public function getListeners():array
		{
			return [
				"echo-presence:document.{$this->subject->room_id},DocumentDeletedEvent" => 'refresh',
				"echo-presence:document.{$this->subject->room_id},DocumentCreatedEvent" => 'refresh',
			];
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
					Risk Assessment
				</x-dropdown.dropdown-button>
			</x-slot:content>
		</x-dropdown.dropdown>
	</div>
	<ul
			role="list"
			class="divide-y divide-gray-100">
		@if($subject->documents->count())
			<x-table-elements.subject-card-table-layout :labels="['File Name', 'Type', 'Size', 'Created At', 'Actions' ]">
				<x-slot:content>
					@foreach($subject->documents as $document)
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