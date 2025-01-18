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
	}

?>

<div class="px-2">
	<div class="flex justify-end p-4">
		<button wire:click="addWarning">
			<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
		</button>
	</div>
	<div class="mt-3 flow-root">
		<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
				@if($subject->documents()->count())
					<div class="space-y-4">
						@foreach($subject->documents as $document)
							<div class='grid grid-cols-3 items-center gap-6'>
								<div class="flex items-center gap-4">
									<x-svg-images.paper-clip class="h-4 w-auto" />
									<a
											href="{{ $document->privateUrl() }}"
											target="_blank"
											class="text-sm truncate w-full">{{ $document->filename }}</a>
								</div>

								<span class="text-sm">{{ $document->size }}</span>
								<span class="text-sm text-left"> {{ $document->extension }}</span>
							</div>
						@endforeach
					</div>
				@else
					<div class="h-full">
						<h3 class="text-7xl text-gray-200 uppercase text-center mt-2">No Documents</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>