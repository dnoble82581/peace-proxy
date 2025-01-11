@props(['labels' => []])
<table class="min-w-full divide-y divide-gray-300">
	<thead class="">
	<tr>
		@foreach($labels as $label)
			<th
					scope="col"
					class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold dark-light-text sm:pl-0">
				{{ $label }}
			</th>
		@endforeach
	</tr>
	</thead>
	<tbody class="divide-y divide-gray-200 bg-white dark:bg-gray-800">
	{{ $slot }}
	</tbody>
</table>