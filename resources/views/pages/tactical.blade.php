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
		<!-- Chat Menu -->
		<div class="grid grid-cols-12 gap-4 mt-4">
			<x-navigation.tab-navigation
					container-class="sm:col-span-4 bg-white"
					:tabs="[
                    ['key' => 'public', 'label' => 'Public'],
                    ['key' => 'private', 'label' => 'Private'],
                    ['key' => 'tactical', 'label' => 'Tactical'],
                ]"
					:default-tab="'tactical'">

				<div x-show="tab === 'public'">
					<livewire:negotiations.negotiation-chat
							:room="$room"
							:toTactical="false"
							:isPrivate="false" />
				</div>
				<div x-show="tab === 'private'">
					<livewire:negotiations.negotiation-chat
							:room="$room"
							:toTactical="false"
							:isPrivate="true" />
				</div>
				<div x-show="tab === 'tactical'">
					<livewire:negotiations.negotiation-chat
							:room="$room"
							:toTactical="true"
							:isPrivate="false" />
				</div>
			</x-navigation.tab-navigation>

			<x-navigation.tab-navigation
					container-class="sm:col-span-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
					:tabs="[
                    ['key' => 'map', 'label' => 'Map'],
                    ['key' => 'objectives', 'label' => 'Objectives'],
                    ['key' => 'charts', 'label' => 'Charts'],
                    ['key' => 'requests', 'label' => 'Requests']
                ]"
					:default-tab="'map'">

				{{--Board--}}
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

				{{--Objectives--}}
				<div x-show="tab === 'objectives'">
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
					<div
							class="mt-4 px-8"
							x-show="chart === 'mood'">
						<livewire:charts.mood-log-chart :room="$room" />
					</div>
					<div
							x-show="chart === 'call'"
							class="mt-4 px-8">
						<livewire:charts.call-log-chart :room="$room" />
					</div>
				</div>

				<div x-show="tab === 'requests'">
					<livewire:cards.request-card :room="$room" />
				</div>
			</x-navigation.tab-navigation>
		</div>
	</div>
</x-tactical-layout>