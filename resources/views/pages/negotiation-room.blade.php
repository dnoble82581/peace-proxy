<x-negotiation-layout>
	<div class="pt-4 overflow-hidden pb-8 px-4">
		{{--SUBJECT AND INFORMATION SECTION--}}
		<div class="flex gap-3">
			<div class="flex-1">
				<livewire:negotiations.negotiation-subject
						:room="$room" />
			</div>

			<div class="flex-1">
				<livewire:negotiations.negotiation-information
						:room="$room" />
			</div>
		</div>

		<div class="h-20 relative">
			<x-buttons.speed-dial />
		</div>
		<!-- CHAT SECTION -->
		<div class="grid grid-cols-12 gap-4">
			<div class="col-span-4">
				<livewire:negotiations.negotiation-chat
						:room="$room" />
			</div>


			{{--BOARD SECTION--}}
			<x-navigation.tab-navigation
					container-class="sm:col-span-8 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
					:tabs="[
                    ['key' => 'board', 'label' => 'Board'],
                    ['key' => 'objectives', 'label' => 'Objectives'],
                    ['key' => 'charts', 'label' => 'Charts'],
                    ['key' => 'requests', 'label' => 'Requests']
                ]"
					:default-tab="'board'">

				{{--Board--}}
				<div x-show="tab === 'board'">
					<div class="space-y-4 max-h-[50rem] overflow-y-auto sticky top-0 overflow-x-hidden">
						<livewire:negotiations.negotiation-hooks :room="$room" />
						<livewire:negotiations.negotiation-triggers :room="$room" />
						<livewire:negotiations.negotiation-demands :room="$room" />
						<livewire:negotiations.negotiation-associate :room="$room" />
					</div>
				</div>

				<div
						x-show="tab === 'objectives'"
						class="space-y-4">
					<livewire:cards.objectives-card
							:negotiationId="$room->negotiation->id"
							:roomId="$room->id" />
				</div>


				{{--CHART SECTION--}}
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
</x-negotiation-layout>

