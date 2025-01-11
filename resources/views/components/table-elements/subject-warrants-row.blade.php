@props(['warrant'])
<tr class="capitalize hover:bg-gray-100 transition-colors ease-in-out">
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->offense }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_county }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_state }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->extraditable }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">
		<button
				class="text-xs text-indigo-500"
				onclick="Livewire.dispatch('modal.open', {component: 'modals.show-warrant', arguments: {{ $warrant->id }}})">
			Open
		</button>
	</td>
</tr>
