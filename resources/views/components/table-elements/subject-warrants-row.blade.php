@props(['warrant'])
<tr class="capitalize hover:bg-gray-100 transition-colors ease-in-out">
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->offense }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_county }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_state }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->extraditable }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text flex gap-4">
		<button
				class="text-xs text-indigo-500"
				onclick="Livewire.dispatch('modal.open', {component: 'modals.show-warrant', arguments: {{ $warrant->id }}})">
			<x-heroicons::outline.envelope-open class="w-4 h-4" />
		</button>
		<button
				wire:click="editWarrant({{ $warrant->id }})"
				class="text-xs text-blue-500">
			<x-heroicons::outline.pencil-square class="w-4 h-4" />
		</button>
		<button
				wire:click="deleteWarrant({{ $warrant->id }})"
				class="text-xs text-rose-500">
			<x-heroicons::outline.trash class="w-4 h-4" />
		</button>
	</td>
</tr>
