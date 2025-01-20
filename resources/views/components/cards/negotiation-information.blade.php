@props(['negotiation', 'hostages' => null])
<div
		x-data="{tab: 'hostages'}"
		class="rounded-lg bg-white shadow col-span-6 dark:bg-gray-800 relative">
	<div class="px-4">
		<div>
			<div class="grid grid-cols-1 sm:hidden">
				<!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
				<select
						aria-label="Select a tab"
						class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
					<option>Subject</option>
					<option>Negotiation</option>
					<option>Weapons</option>
					<option>Mental Health</option>
				</select>
			</div>
			<div class="hidden sm:block">
				<div class="border-b border-gray-200">
					<nav
							class="-mb-px flex space-x-8"
							aria-label="Tabs">
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
					</nav>
				</div>
			</div>
		</div>
		<div class="h-48 p-2 overflow-y-auto overflow-x-hidden">
			<div
					x-show="tab === 'hostages'">
				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 mt-3 px-2 pb-4">
					@if($hostages->count())
						@foreach($hostages as $hostage)
							<x-cards.hostage-tiny-card :hostage="$hostage" />
						@endforeach
					@else
						<div class="col-span-2">
							<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Hostages</h3>
						</div>
					@endif
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
				@if($negotiation->objectives()->count())
					<div class="px-6 h-48">
						<ol class="list-decimal px-4">
							@foreach($negotiation->objectives->sortBy('priority') as $objective)
								<li class="">{{ $objective->objective }}
									<span class="text-sm text-gray-400">({{ $objective->getPriorityString($objective->priority) }})</span>
								</li>
							@endforeach
						</ol>
					</div>
				@else
					<div class="col-span-2">
						<h3 class="text-7xl text-gray-200 uppercase text-center mt-8">No Objectives</h3>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>