@props(['associate' => null])
<li
		x-data="{ details: true }"
		class="dark:bg-gray-700 rounded shadow">
	<div class="flex items-center justify-between gap-x-6 p-4">
		<div class="flex items-center gap-x-3">
			@if($associate->images()->count())
				<img
						class="w-14 h-14 rounded-full"
						src="{{ $associate->imageUrl($associate->images()->first()->image) }}"
						alt="">
			@else
				<img
						class="w-14 h-14 rounded-full"
						src="{{ $associate->temporaryImageUrl() }}"
						alt="temporary image">
			@endif
			<div class="min-w-0">
				<div class="flex items-start gap-x-3">
					<p class="text-sm/6 font-semibold dark-light-text capitalize">{{ $associate->name }}</p>
					<span class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 capitalize">status</span>
				</div>
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-slate-300">
					<p class="whitespace-nowrap dark-light-text">
						{{ $associate->email }}
					</p>
				</div>
			</div>
		</div>
		<div
				class="flex flex-none items-center gap-x-4">
			<span class="sr-only">, Demand Details</span>
			<div class="relative flex items-center gap-x-2">
				<div class="min-w-0">
					<div class="flex items-start gap-x-3 justify-end">
						<p class="text-sm/6 font-semibold dark-light-text capitalize">{{ $associate->relationship_to_subject }}</p>
					</div>
					<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-slate-300">
						<p class="whitespace-nowrap dark-light-text">Last Contact:
							{{ $associate->last_contacted_at ? $associate->last_contacted_at->diffForHumans() : '' }}
						</p>
					</div>
				</div>
				<button
						@click="details = !details"
						:aria-expanded="details.toString()"
						aria-controls="details-content"
						@keydown.enter="details = !details"
						@keydown.space.prevent="details = !details"
						class="focus:outline-none focus-visible:ring focus-visible:ring-offset-2 focus-visible:ring-blue-500">
					<span class="sr-only">Toggle Details</span>
					<x-heroicons::mini.solid.chevron-up-down class="dark-light-text" />
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
									wire:click="editAssociate({{ $associate->id }})"
									class="block px-3 py-1 text-sm/6 dark-light-text h-full"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-1">Edit<span class="sr-only">, Edit Associate</span>
							</button>
						</x-dropdown.dropdown-link>
						<x-dropdown.dropdown-link>
							<button
									wire:click="showAssociate({{ $associate->id }})"
									class="block px-3 py-1 text-sm/6 dark-light-text h-full"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-1">View<span class="sr-only">, View Associate</span>
							</button>
						</x-dropdown.dropdown-link>
						<x-dropdown.dropdown-link>
							<button
									wire:click="deleteAssociate({{ $associate->id }})"
									class="block px-3 py-1 text-sm/6 dark-light-text h-full"
									role="menuitem"
									tabindex="-1"
									id="options-menu-0-item-1">Delete<span class="sr-only">, Delete Associate</span>
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
				{{ $associate->notes }}
			</p>
		</div>
	</div>
</li>