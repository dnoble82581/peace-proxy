<?php

	use App\Models\Subject;
	use Livewire\Volt\Component;
	use function Livewire\Volt\{state};

	new class extends Component {
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

		public function deleteDocument($documentId)
		{
			dd($documentId);
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
						<tr class="even:bg-gray-50">
							<td class="py-2 pr-3 pl-4 text-xs font-medium whitespace-nowrap text-gray-900 sm:pl-3">
								{{ $document->filename }}
							</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap text-gray-500">{{ $document->type }}</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap text-gray-500">{{ round($document->size/1000) }}
								kb
							</td>
							<td class="px-3 py-2 text-xs whitespace-nowrap text-gray-500">{{ $document->created_at->diffForHumans() }}
							</td>
							<td class="relative py-2 space-x-2 pr-4 pl-3 text-left text-xs font-medium whitespace-nowrap sm:pr-3 flex">
								<a
										href="{{ $document->privateUrl() }}"
										target="_blank">
									<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
								</a>
								<button
										type="button"
										wire:click="deleteDocument({{ $document->id }})">
									<x-heroicons::outline.trash class="w-4 h-4 hover:text-red-500 text-red-400 cursor-pointer" />
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