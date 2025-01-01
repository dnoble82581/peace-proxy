<div class="p-4">
	<ul
			role="list"
			class="divide-y divide-gray-100">
		<li class="gap-x-6 grid grid-cols-6 items-center">
			<div class="col-span-6">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm/6 font-semibold text-gray-900">
							<a
									href="#"
									class="hover:underline">{{ $this->message->message }}</a>
						</p>
					</div>


				</div>

				<div class="text-xs/5 text-gray-500 divide-y divide-gray-200 space-y-3">
					@foreach($this->message->responses as $response)
						<div>
							<p class="mt-4">
								{{ $response->response }}
							</p>
							<div class="flex items-center justify-between mt-2 px-4">
								<div>
									<span>20 minutes ago by Chris Wisman</span>
								</div>
								<div class="flex items-center gap-x-2">
									<button
											wire:click="acknowledge({{ $response->id }})"
											@click="acknowledged = !acknowledged">
										@if($response->acknowledged)
											<x-heroicons::mini.solid.check-circle
													class="w-7 h-7 text-green-500" />
										@else
											<x-heroicons::mini.solid.x-circle
													class="w-7 h-7 text-rose-500" />
										@endif
									</button>

								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</li>
	</ul>
</div>

