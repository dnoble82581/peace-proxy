@props(['subject'])
<div class="px-4 sm:px-6 lg:px-8">
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
						<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Documents</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>