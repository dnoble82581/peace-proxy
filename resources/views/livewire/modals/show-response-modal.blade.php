<ul
		role="list"
		class="divide-y divide-gray-100 p-8">
	@foreach($subjectRequest->responses->where('dismissed', false) as $response)
		<li
				class="py-5">
			<div class="min-w-0">
				<div class="flex gap-x-3 justify-between">
					<p class="text-sm/6 font-semibold text-gray-900">{{ $subjectRequest->subject_request }}</p>
					<div>
						<p class="text-xs/5 text-gray-500 font-normal">Submtted
						                                               by {{ $subjectRequest->user->name }}</p>
						<p class="text-xs/5 text-gray-500 font-normal">{{ $response->created_at->diffForHumans() }}</p>
					</div>

				</div>
				<div class="flex justify-between mt-5">
					<div class="mt-1 flex flex-1 pr-6 items-center gap-x-2 text-xs/5 text-gray-500">
						<p>{{ $response->body }}</p>
					</div>
					<div>
						<button
								class="text-xs/5 text-rose-500 underline"
								type="button"
								wire:click="dismiss({{ $response->id }})">
							Dismiss
						</button>
					</div>
				</div>

			</div>
		</li>
	@endforeach
	<div class="pt-5 border-gray-100 flex justify-end">
		<x-buttons.primary-button
				type="button"
				wire:click="close()"
				value="Close" />
	</div>
</ul>

