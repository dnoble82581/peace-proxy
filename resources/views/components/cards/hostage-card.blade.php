@props(['hostage' => null])
<div x-data="{ details: true}">
	<li class="relative flex justify-between gap-x-6 py-5">
		<div class="flex min-w-0 gap-x-4">
			@if($hostage->images()->count())
				<img
						class="size-12 flex-none rounded-full bg-gray-50"
						src="{{ $hostage->imageUrl($hostage->images->first()->image) }}"
						alt="">
			@else
				<img
						class="size-12 flex-none rounded-full bg-gray-50"
						src="{{ $hostage->temporaryImageUrl() }}"
						alt="Temporary Image">
			@endif

			<div class="min-w-0 flex-auto">
				<p class="text-sm/6 font-semibold dark-light-text">
					<a href="#">
						{{ $hostage->name }}
					</a>
				</p>
				<p class="mt-1 flex text-xs/5 text-gray-500">
					<a
							href="mailto:{{ $hostage->email }}"
							class="relative truncate hover:underline">{{ $hostage->email ?? $hostage->phone }}</a>
				</p>
			</div>
		</div>
		<div class="flex shrink-0 items-center gap-x-4">
			<div class="hidden sm:flex sm:flex-col sm:items-end">
				<p class="text-sm/6 dark-light-text">{{ $hostage->relationship_to_subject }}</p>
				<p class="mt-1 text-xs/5 text-gray-500">Last Contact
					<time datetime="2023-01-23T13:23Z">{{ isset($hostage->last_contacted_at) ? $hostage->last_contacted_at->diffForHumans() : 'None' }}</time>
				</p>
			</div>
			<button
					@click="details = !details"
					type="button"
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
								wire:click="editHostage('{{ $hostage->id }}')"
								type="button"
								class="block px-3 py-1 text-sm/6 text-gray-900 w-full"
								role="menuitem"
								tabindex="-1"
								id="options-menu-0-item-0">Edit<span class="sr-only">, Edit Hostage</span>
						</button>
					</x-dropdown.dropdown-link>
					<x-dropdown.dropdown-link>
						<button

								class="block px-3 py-1 text-sm/6 text-gray-900 w-full h-full"
								role="menuitem"
								tabindex="-1"
								id="options-menu-0-item-1">Delete<span class="sr-only">, Delete Hostage</span></button>
					</x-dropdown.dropdown-link>
				</x-slot:content>
			</x-dropdown.dropdown>
		</div>
	</li>
	<div
			x-show="details"
			x-transition:enter="transition ease-out duration-200"
			x-transition:enter-start="opacity-0 scale-95"
			x-transition:enter-end="opacity-100 scale-100"
			x-transition:leave="transition ease-in duration-75"
			x-transition:leave-start="opacity-100 scale-100"
			x-transition:leave-end="opacity-0 scale-95"
			class="border-t border-b border-gray-200 dark:border-slate-300 py-2 px-6">
		<p class="text-sm/6 text-gray-500 dark:text-slate-300">{{ $hostage->notes }}</p>
	</div>
</div>