@php use Carbon\Carbon; @endphp
@props(['demand', 'room'])
<li
		x-data="{ details: true }"
		class="dark:bg-gray-700 rounded shadow">
	<div class="flex items-center justify-between gap-x-6 p-4">
		<div class="min-w-0 flex-1">
			<div class="flex items-start gap-x-3">
				<p class="text-sm/6 font-semibold dark-light-text capitalize">{{ $demand->title }}</p>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-slate-300">
				<p class="whitespace-nowrap text-red-700 dark:text-slate-300">Due
					<time datetime="{{ $demand }}">{{ $demand->deadline->diffForHumans() }}</time>
				</p>
			</div>
		</div>
		<div class="min-w-0 flex-1">
			<div class="flex items-start gap-x-3">
				<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">Status</p>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
					<span class="inline-flex items-center rounded-md  px-1.5 py-0.5 text-xs font-medium {{$demand->getBadgeColor()}} ring-1 ring-inset capitalize">{{ $demand->status }}</span>
				</div>
			</div>
		</div>
		<div class="min-w-0 flex-1">
			<div class="flex items-start gap-x-3">
				<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300 flex items-center gap-2">
					Plans</p>
				<div>
					@can('attach', App\Models\Plan::class)
						<x-dropdown.dropdown>
							<x-slot:trigger>
								<button>
									<x-heroicons::micro.solid.plus class="size-4 text-gray-500" />
								</button>
							</x-slot:trigger>
							<x-slot:content>
								@if ($room->plans->count())
									@foreach ($room->plans as $plan)
										<x-dropdown.dropdown-button
												wire:click="attachDeliveryPlan({{ $plan->id }}, {{ $demand->id }})"
												:value="$plan->title" />
									@endforeach
								@else
									<span class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out">No Plans Created</span>
								@endif
							</x-slot:content>
						</x-dropdown.dropdown>
					@endcan
				</div>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
				<div class="mt-1 text-xs/5 text-gray-500">
					@if ($demand->plans()->count())
						@foreach ($demand->plans as $plan)
							<div class="gap-x-2 text-xs/5 text-gray-500">
								<button
										wire:click="showPlan({{ $plan->id }})"
										class="whitespace-nowrap text-blue-500 dark:text-blue-300">{{ $plan->title }}</button>
								@can('detach', App\Models\Plan::class)
									<button wire:click="detachDeliveryPlan({{ $plan->id }}, {{ $demand->id }})">
										<x-heroicons::outline.trash class="size-3 text-rose-400" />
									</button>
								@endcan
							</div>
						@endforeach
					@else
						None
					@endif
				</div>
			</div>
		</div>
		<div class="min-w-0 flex-1">
			<div class="flex items-start gap-x-3">
				<div class="flex items-center gap-x-2 text-xs/5 text-gray-500">
					<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">Responses</p>
					@can('create', App\Models\Response::class)
						<button wire:click="createResponse({{ $demand->id }})">
							<x-heroicons::micro.solid.plus class="size-4" />
						</button>
					@endcan
				</div>
			</div>
			<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
					@if ($demand->responses()->exists())
						<button>Responses: {{ $demand->responses()->count() }}</button>
					@else
						<p class="whitespace-nowrap text-gray-500 dark:text-slate-300">None</p>
					@endif
				</div>
			</div>
		</div>
		<div
				class="flex flex-none items-center gap-x-4">
			<span class="sr-only">, Demand Details</span>
			<div class="relative flex items-center gap-x-2">
				<button
						@click="details = !details"
						:aria-expanded="details.toString()"
						aria-controls="details-content"
						@keydown.enter="details = !details"
						@keydown.space.prevent="details = !details"
						class="focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-blue-500">
					<span class="sr-only">Toggle Details</span>
					<x-heroicons::mini.solid.chevron-up-down />
				</button>
				<x-dropdown.dropdown
						width="40">
					<x-slot:trigger>
						<button
								type="button"
								class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900"
								id="options-menu-0-button"
								aria-expanded="false"
								aria-haspopup="true">
							<span class="sr-only">Open options</span>
							<svg
									class="size-5 dark:text-slate-300"
									viewBox="0 0 20 20"
									fill="currentColor"
									aria-hidden="true"
									data-slot="icon">
								<path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
							</svg>
						</button>
					</x-slot:trigger>
					<x-slot:content class="overflow-x-visible overflow-y-visible">
						<x-dropdown.dropdown-link>
							<button
									wire:click="sendRequest({{ $demand->id }})"
									class="block px-3 py-1 text-sm/6 text-gray-900 dark-light-text"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-0">Request<span class="sr-only">, Request Demand</span>
							</button>
						</x-dropdown.dropdown-link>
						<x-dropdown.dropdown-link>
							<button
									wire:click="editDemand({{ $demand->id }})"
									class="block px-3 py-1 text-sm/6 text-gray-900 h-full dark-light-text"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-1">Edit<span class="sr-only">, Edit Demand</span></button>
						</x-dropdown.dropdown-link>
						<x-dropdown.dropdown-link>
							<button
									wire:click="deleteDemand({{ $demand->id }})"
									class="block px-3 py-1 text-sm/6 text-gray-900 h-full dark-light-text"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-1">Delete<span class="sr-only">, Delete Demand</span>
							</button>
						</x-dropdown.dropdown-link>
					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	</div>
	<div>
		<div
				x-show="details"
				x-transition:enter="transition ease-out duration-200"
				x-transition:enter-start="opacity-0 scale-95"
				x-transition:enter-end="opacity-100 scale-100"
				x-transition:leave="transition ease-in duration-75"
				x-transition:leave-start="opacity-100 scale-100"
				x-transition:leave-end="opacity-0 scale-95"
				class="border-t border-b border-gray-200 dark:border-slate-300 py-2 px-6">
			<p
					role="region"
					class="text-sm/6 text-gray-500 dark:text-slate-300">
				{{ $demand->description }}
			</p>
		</div>
	</div>
</li>