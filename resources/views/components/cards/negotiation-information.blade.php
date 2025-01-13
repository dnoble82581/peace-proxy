@props(['negotiation', 'hostages'])
<div
		x-data="{tab: 'hostages'}"
		class="overflow-y-scroll rounded-lg bg-white shadow col-span-6 dark:bg-gray-800 relative">
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
				<button
						@click="tab = 'objectives'"
						class="group inline-flex items-center border-b-2 px-1 py-2 text-sm font-medium"
						:class="tab === 'objectives' ? 'border-indigo-500 border-b-2 text-indigo-600 dark:text-indigo-400 dark:border-indigo-500' : 'border-transparent dark-light-text hover:border-gray-300 dark:hover:text-gray-400 hover:text-gray-700'">
					<x-heroicons::micro.solid.identification class="w-5 h-5 mr-2" />
					<span>Objectives</span>
				</button>
			</x-slot:content>
		</x-navigation.card-navigation>
	</div>
	<div
			class="overflow-visible"
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
	<div x-show="tab === 'objectives'">
		<div class="flex justify-end px-4 mt-2">
			<button onclick="Livewire.dispatch('modal.open', {component: 'modals.create-objective-form', arguments: {negotiationId: {{$negotiation->id}}}})">
				<x-heroicons::micro.solid.plus class="w-5 h-5 hover:text-gray-500 text-gray-400 cursor-pointer" />
			</button>
		</div>
		@if($hostage->negotiation->objectives()->count())
			<div class="px-6">
				<ol class="list-decimal px-4">
					@foreach($hostage->negotiation->objectives->sortBy('priority') as $objective)
						<li class="">{{ $objective->objective }}
							<span class="text-sm text-gray-400">({{ $objective->getPriorityString($objective->priority) }})</span>
						</li>
					@endforeach
				</ol>
			</div>
		@endif
	</div>
</div>