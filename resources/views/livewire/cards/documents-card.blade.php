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
	}

?>

<div class="px-2">
	<div class="flex justify-end px-4">
		<button wire:click="createForm">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<ul
			role="list"
			class="divide-y divide-gray-100">
		@foreach($this->subject->documents as $document)
			<li class="flex justify-between gap-x-6 py-5">
				<div class="flex min-w-0 gap-x-4">
					<x-svg-images.documents.pdf class="w-10 h-10" />
					<div class="min-w-0 flex-auto">
						<p class="text-sm/6 font-semibold text-gray-900">
							<a
									href="{{ $document->privateUrl() }}"
									target="_blank"
									class="hover:underline text-sm">{{ $document->filename }}</a>
						</p>
						<p class="mt-1 flex text-xs/5 text-gray-500">
							<apan
									class="truncate hover:underline">{{ round($document->size/1000) }}KB
							</apan>
						</p>
					</div>
				</div>
				<div class="flex shrink-0 items-center gap-x-6">
					<div class="hidden sm:flex sm:flex-col sm:items-end">
						<p class="text-sm/6 text-gray-900"> {{ $document->type }}</p>
						<p class="mt-1 text-xs/5 text-gray-500">Created
							<time datetime="2023-01-23T13:23Z">{{ $document->updated_at->diffForHumans() }}</time>
						</p>
					</div>
					<div
							class="relative flex-none">
						<x-dropdown.dropdown>
							<x-slot:trigger>
								<button
										@click="show = !show"
										type="button"
										class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900"
										id="options-menu-0-button"
										aria-expanded="false"
										aria-haspopup="true">
									<span class="sr-only">Open options</span>
									<x-heroicons::solid.ellipsis-vertical class="w-5 h-5" />
								</button>
							</x-slot:trigger>
							<x-slot:content>
								<x-dropdown.dropdown-button>
									Delete
								</x-dropdown.dropdown-button>
							</x-slot:content>
						</x-dropdown.dropdown>
					</div>
				</div>
			</li>
		@endforeach
	</ul>
</div>