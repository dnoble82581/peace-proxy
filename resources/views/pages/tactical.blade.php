<x-tactical-layout>
	<div class="p-10">
		<div>
			<livewire:alerts.tactical-alerts :room="$room" />
		</div>
		<div class="flex items-center gap-3">
			<div class="flex-1">
				<livewire:negotiations.negotiation-subject
						:room="$room" />
			</div>

			<div class="flex-1">
				<livewire:negotiations.negotiation-information
						:room="$room" />
			</div>
		</div>

		<div class="mb-5 flex gap-5">
			<input
					type="text"
					id="query-input"
					value="{{ $room->negotiation->address }}"
					placeholder="Search"
					class="w-full rounded-lg shadow-lg">
			<x-buttons.primary-button id="search-button">Search</x-buttons.primary-button>
		</div>
		<div class="flex gap-5">
			<div
					id="map"
					class="w-1/2 h-[40rem] rounded-lg shadow-lg">
			</div>
			<div
					id="map-2"
					class="w-1/2 h-[40rem] rounded-lg shadow-lg">
			</div>
		</div>
	</div>
</x-tactical-layout>