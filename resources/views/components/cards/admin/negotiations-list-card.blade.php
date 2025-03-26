@props(['negotiation'])
<li class="flex items-center justify-between gap-x-6 py-5">
	<div class="min-w-0">
		<div class="flex items-start gap-x-3">
			<p class="text-sm/6 font-semibold text-[#dddddd] capitalize">{{ $negotiation->title }}</p>
			<p class="mt-0.5 rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium whitespace-nowrap text-green-700 ring-1 ring-green-600/20 ring-inset">
				{{ $negotiation->status }}</p>
		</div>
		<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
			<p class="whitespace-nowrap">Created
				<time datetime="2023-03-17T00:00Z">{{ $negotiation->start_time->diffForHumans() }}</time>
			</p>
			<svg
					viewBox="0 0 2 2"
					class="size-0.5 fill-current">
				<circle
						cx="1"
						cy="1"
						r="1" />
			</svg>
			<p class="truncate">Created by {{ $negotiation->user->name ?? 'Unknown' }}</p>
		</div>
	</div>
	<div class="flex flex-none items-center gap-x-4">
		<a
				href="{{ route('show.negotiation', $negotiation->id) }}"
				target="_blank"
				class="hidden rounded-md bg-[#1a1a1b] px-2.5 py-1.5 text-sm font-semibold text-[#dddddd]  hover:bg-[#3a3a3a] ring-1 shadow-xs ring-gray-300 ring-inset sm:block">View
		                                                                                                                                                                         Negotiation<span class="sr-only">, View Negotiation</span></a>
		<div class="relative flex-none">
			<x-dropdown.dropdown width="40">
				<x-slot:trigger>
					<button
							type="button"
							class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900"
							id="options-menu-0-button"
							aria-expanded="false"
							aria-haspopup="true">
						<span class="sr-only">Open options</span>
						<x-heroicons::mini.solid.ellipsis-vertical class="w-5 h-5" />
					</button>
				</x-slot:trigger>
				<x-slot:content>
					<!-- Active: "bg-gray-50 outline-hidden", Not Active: "" -->
					<a
							href="#"
							class="block px-3 py-1 text-sm/6 text-gray-900"
							role="menuitem"
							tabindex="-1"
							id="options-menu-0-item-0">Edit<span class="sr-only">, GraphQL API</span></a>
					<a
							href="#"
							class="block px-3 py-1 text-sm/6 text-gray-900"
							role="menuitem"
							tabindex="-1"
							id="options-menu-0-item-1">Move<span class="sr-only">, GraphQL API</span></a>
					<a
							href="#"
							class="block px-3 py-1 text-sm/6 text-gray-900"
							role="menuitem"
							tabindex="-1"
							id="options-menu-0-item-2">Delete<span class="sr-only">, GraphQL API</span></a>
				</x-slot:content>
			</x-dropdown.dropdown>

		</div>
	</div>
</li>