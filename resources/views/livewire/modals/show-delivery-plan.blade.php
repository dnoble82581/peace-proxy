<div class="p-6">
	<div class="px-4 sm:px-0">
		<h3 class="text-base/7 font-semibold text-gray-900">{{ $deliveryPlan->title }}</h3>
		<p class="mt-1 max-w-2xl text-sm/6 text-gray-500">Personal details and application.</p>
	</div>
	<div class="mt-6 border-t border-gray-100">
		<dl class="divide-y divide-gray-100">
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Created By</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $deliveryPlan->user->name }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Delivery Location</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $deliveryPlan->delivery_location }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Special Instructions</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $deliveryPlan->special_instructions }}
				</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900">Notes</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0">{{ $deliveryPlan->notes }}
				</dd>
			</div>
			@if ($deliveryPlan->documents()->count())
				<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
					<dt class="text-sm/6 font-medium text-gray-900">Attachments</dt>
					<dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
						<ul
								role="list"
								class="divide-y divide-gray-100 rounded-md border border-gray-200">
							@foreach($deliveryPlan->documents as $document)
								<li class="flex items-center justify-between py-4 pr-5 pl-4 text-sm/6">
									<div class="flex w-0 flex-1 items-center">
										<svg
												class="size-5 shrink-0 text-gray-400"
												viewBox="0 0 20 20"
												fill="currentColor"
												aria-hidden="true"
												data-slot="icon">
											<path
													fill-rule="evenodd"
													d="M15.621 4.379a3 3 0 0 0-4.242 0l-7 7a3 3 0 0 0 4.241 4.243h.001l.497-.5a.75.75 0 0 1 1.064 1.057l-.498.501-.002.002a4.5 4.5 0 0 1-6.364-6.364l7-7a4.5 4.5 0 0 1 6.368 6.36l-3.455 3.553A2.625 2.625 0 1 1 9.52 9.52l3.45-3.451a.75.75 0 1 1 1.061 1.06l-3.45 3.451a1.125 1.125 0 0 0 1.587 1.595l3.454-3.553a3 3 0 0 0 0-4.242Z"
													clip-rule="evenodd" />
										</svg>
										<div class="ml-4 flex min-w-0 flex-1 gap-2">
											<span class="truncate font-medium">{{ $document->filename }}</span>
											<span class="shrink-0 text-gray-400">{{ $document->size }}</span>
										</div>
									</div>
									<div class="ml-4 shrink-0 space-x-3">
										<a
												href="{{ $document->privateUrl() }}"
												target="_blank">
											<x-heroicons::outline.envelope-open class="w-4 h-4 hover:text-indigo-500 text-indigo-400 cursor-pointer" />
										</a>
									</div>
								</li>
							@endforeach
						</ul>
					</dd>
				</div>
			@endif
		</dl>
	</div>
</div>
