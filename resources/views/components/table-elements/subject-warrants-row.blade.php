@props(['warrant'])
<tr class="capitalize">
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->offense }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_county }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_agency }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->originating_state }}</td>
	<td class="whitespace-nowrap px-2 py-2 text-sm dark-light-text">{{ $warrant->extraditable }}</td>
</tr>
