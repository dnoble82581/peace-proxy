@props(['negotiation', 'hostages'])
<div
		x-data="{tab: 'hostages'}"
		class="overflow-hidden rounded-lg bg-white shadow col-span-6 dark:bg-gray-800 relative">
	<div class="px-4">
		<x-navigation.card-navigation :labels="['General', 'Test']">
			<x-slot:content>
				<button
						@click="tab = 'hostages'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'hostages' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Hostages</span>
				</button>
				<button
						@click="tab = 'negotiation'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'negotiation' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Negotiation</span>
				</button>
			</x-slot:content>
		</x-navigation.card-navigation>
	</div>
	<div
			class="overflow-scroll"
			x-show="tab === 'hostages'">
		<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-3 px-2 pb-4">
			@foreach($hostages as $hostage)
				<x-cards.hostage-tiny-card :hostage="$hostage" />
			@endforeach
		</div>
	</div>
	<div x-show="tab === 'negotiation'">
		<x-cards.negotiations.general-negotiation-card :negotiation="$negotiation" />
	</div>
</div>