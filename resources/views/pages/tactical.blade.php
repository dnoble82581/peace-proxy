<x-tactical-layout>
	<div class="p-10">
		<div>
			<livewire:alerts.tactical-alerts :room="$room" />
		</div>
		<div class="max-w-full w-full mx-auto sm:grid sm:grid-cols-12 sm:gap-3 pt-4 overflow-hidden pb-8">
			<livewire:negotiations.negotiation-subject :room="$room" />
			<x-cards.negotiation-information
					:negotiation="$room->negotiation"
					:hostages="$room->subject->associates->where('relationship_to_subject', 'Hostage')" />
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