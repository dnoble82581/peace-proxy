<x-tactical-layout>
	{{--	<livewire:alerts.tactical-alerts :room="$room" />--}}
	<div class="pt-4 overflow-hidden pb-8 px-4">
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

		<div class="py-3">
			<x-buttons.speed-dial />
		</div>

		<!-- Chat Menu -->
		<div class="grid grid-cols-12 gap-4 mt-4">
			<div class="col-span-4">
				<livewire:negotiations.negotiation-chat
						:room="$room" />
			</div>

			<x-navigation.tab-navigation
					container-class="sm:col-span-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
					:tabs="[
                    ['key' => 'map', 'label' => 'Map'],
                    ['key' => 'demands', 'label' => 'Demands'],
                    ['key' => 'objectives', 'label' => 'Objectives'],
                    ['key' => 'charts', 'label' => 'Charts'],
                    ['key' => 'requests', 'label' => 'Requests']
                ]"
					:default-tab="'map'">

				{{--Maps--}}
				<div x-show="tab === 'map'">
					<div class="space-y-4 max-h-[610px] overflow-y-auto sticky top-0 overflow-x-hidden px-8 py-2">
						<div class="flex-1 flex gap-3 items-center">
							<x-input
									id="query-input"
									value="{{ $room->negotiation->address }}"
									placeholder="Search" />
							<x-button
									id="search-button"
									label="Search" />
						</div>
						<div class="flex gap-2">
							<div
									id="map"
									class="w-1/2 h-[30rem] rounded-lg shadow-lg">
							</div>
							<div
									x-cloak
									id="map-2"
									class="w-1/2 h-[30rem] rounded-lg shadow-lg">
							</div>
						</div>
					</div>
				</div>

				{{--				Demands--}}
				<div x-show="tab === 'demands'">
					<div class="mt-4 max-h-[50rem] overflow-y-auto sticky top-0 overflow-x-hidden">
						<livewire:negotiations.negotiation-demands :room="$room" />
					</div>
				</div>

				{{--Objectives--}}
				<div
						x-show="tab === 'objectives'"
						class="space-y-4">
					<livewire:cards.objectives-card
							:negotiationId="$room->negotiation->id"
							:roomId="$room->id" />
				</div>

				{{--Charts--}}

				<div
						class="mt-4"
						x-show="tab === 'charts'"
						x-data="{ chart: 'mood' }">

					<x-buttons.button-group
							:buttons="[
            ['key' => 'mood', 'label' => 'Mood Chart'],
            ['key' => 'call', 'label' => 'Call Log'],
        ]"
							click-handler="chart"
							class="ml-8" />

					<div x-show="chart === 'mood'">
						<livewire:charts.mood-log-chart :room="$room" />
					</div>
					<div x-show="chart === 'call'">
						<livewire:charts.call-log-chart :room="$room" />
					</div>
				</div>

				{{--REQUEST SECTION--}}
				<div
						class="mt-4"
						x-show="tab === 'requests'"
						x-data="{list: 'subject'}">

					<x-buttons.button-group
							:buttons="[
									['key' => 'subject', 'label' => 'Subject Requests'],
									['key' => 'information', 'label' => 'RFI'],
						]"
							click-handler="list"
							class="ml-8" />

					<div x-show="list === 'subject'">
						<livewire:cards.request-card :room="$room" />
					</div>
					<div x-show="list === 'information'">
						<livewire:cards.rfi-card :room="$room" />
					</div>
				</div>
			</x-navigation.tab-navigation>
		</div>
	</div>
</x-tactical-layout>