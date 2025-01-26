<x-negotiation-layout>
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
					:default-tab="'public'">

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
                    ['key' => 'board', 'label' => 'Board'],
                    ['key' => 'objectives', 'label' => 'Objectives'],
                    ['key' => 'charts', 'label' => 'Charts'],
                ]"
					:default-tab="'board'">

				<div x-show="tab === 'board'">
					<div class="space-y-4 max-h-[610px] overflow-y-auto sticky top-0 overflow-x-hidden">
						<livewire:negotiations.negotiation-hooks :room="$room" />
						<livewire:negotiations.negotiation-triggers :room="$room" />
						<livewire:negotiations.negotiation-demands :room="$room" />
						<livewire:negotiations.negotiation-associate :room="$room" />
					</div>
				</div>
				<div x-show="tab === 'objectives'">
					<livewire:cards.objectives-card
							:negotiationId="$room->negotiation->id"
							:roomId="$room->id" />
				</div>

				<div
						x-show="tab === 'charts'"
						x-data="{ chart: 'mood' }">
					<div class="ml-8">
						<span class="isolate inline-flex rounded-md shadow-xs">
                            <button
		                            @click="chart = 'mood'"
		                            type="button"
		                            class="relative inline-flex items-center rounded-l-md  px-3 py-2 text-xs font-semibold  ring-1 ring-gray-300 ring-inset focus:z-10"
		                            :class="chart === 'mood' ? 'bg-indigo-100 text-gray-700 hover:bg-indigo-50' : 'bg-white text-gray-900 hover:bg-gray-50'"
                            >
	                            Mood Chart
                            </button>
                             <button
		                             @click="chart = 'call'"
		                             type="button"
		                             class="relative inline-flex items-center rounded-r-md  px-3 py-2 text-xs font-semibold  ring-1 ring-gray-300 ring-inset  focus:z-10"
		                             :class="chart === 'call' ? 'bg-indigo-100 text-gray-700 hover:bg-indigo-50' : 'bg-white text-gray-900 hover:bg-gray-50'"
                             >
	                            Call Log
                            </button>
						</span>

					</div>
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
			</x-navigation.tab-navigation>
		</div>
	</div>
</x-negotiation-layout>

