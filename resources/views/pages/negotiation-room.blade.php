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
					container-class="sm:col-span-3 bg-white"
					:tabs="[
                    ['key' => 'public', 'label' => 'Public'],
                    ['key' => 'private', 'label' => 'Private'],
                    ['key' => 'tactical', 'label' => 'Tactical'],
                ]"
					:default-tab="'public'">

				<div x-show="tab === 'public'">
					<livewire:negotiations.negotiation-chat :room="$room" />
				</div>
				<div x-show="tab === 'private'">
					Private Content
				</div>
				<div x-show="tab === 'tactical'">
					Tactical Content
				</div>
			</x-navigation.tab-navigation>

			<x-navigation.tab-navigation
					container-class="sm:col-span-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg"
					:tabs="[
                    ['key' => 'board', 'label' => 'Board'],
                    ['key' => 'objectives', 'label' => 'Objectives('.$room->negotiation->objectives->count().')'],
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
			</x-navigation.tab-navigation>

			<x-navigation.tab-navigation
					container-class="col-span-3 max-h-[690px] overflow-hidden bg-white dark:bg-gray-800 rounded-lg shadow-lg"
					:tabs="[
                    ['key' => 'charts', 'label' => 'Charts'],
                    ['key' => 'lies', 'label' => 'Lies'],
                ]"
					:default-tab="'charts'">

				<div x-show="tab === 'charts'">
					<div class="mt-4">
						<div>
							<livewire:charts.mood-log-chart :room="$room" />
						</div>
						<div>
							<livewire:charts.call-log-chart :room="$room" />
						</div>
					</div>
				</div>
				<div x-show="tab === 'lies'">
					Lies information here
				</div>
			</x-navigation.tab-navigation>
		</div>
	</div>
</x-negotiation-layout>

