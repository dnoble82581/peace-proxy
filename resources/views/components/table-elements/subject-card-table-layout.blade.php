@props(['labels' => [], 'content' => ''])
<div class="px-2 sm:px-4">
	<div class="mt-2 flow-root">
		<div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
			<div class="inline-block min-w-full align-middle sm:px-6 lg:px-8">
				<table class="min-w-full divide-y divide-gray-300">
					<thead>
					<tr>
						@foreach($labels as $label)
							@if($loop->first)
								<th
										scope="col"
										class="py-1.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-3">{{ $label }}
								</th>
							@else
								<th
										scope="col"
										class="px-3 py-1.5 text-left text-sm font-semibold text-gray-900">{{ $label }}
								</th>
							@endif
						@endforeach
					</tr>
					</thead>

					<tbody class="bg-white">

					{{ $content }}
					
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>