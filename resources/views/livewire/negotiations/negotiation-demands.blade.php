<?php

use Livewire\Volt\Component;

new class extends Component {
    public function addDemand()
    {
        $this->dispatch('modal.open', component: 'modals.create-demand-form');
    }
}

?>

{{--ToDo:finish demands--}}
<div class="mt-5">
	<x-board-elements.category-header
			class="bg-teal-400 dark:bg-teal-600"
			value="Demands"
			click-action="addDemand()">
		<x-slot:actions>
			<x-heroicons::mini.solid.chevron-up-down class="w-5 h-5 text-slate-700 dark:text-slate-300" />
		</x-slot:actions>
	</x-board-elements.category-header>
	<ul
			role="list"
			class="divide-y divide-gray-100 px-6 mt-3 dark:divide-gray-700">
		<li class="flex items-center justify-between gap-x-6 py-5 dark:bg-gray-700 px-2 rounded-md">
			<div class="min-w-0">
				<div class="flex items-start gap-x-3">
					<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">Drugs and Cigarettes</p>
					<span class="inline-flex items-center rounded-md bg-green-50 px-1.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Complete</span>
				</div>
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500 dark:text-slate-300">
					<p class="whitespace-nowrap text-red-700 dark:text-slate-300">Due on
						<time datetime="2023-03-17T00:00Z">March 17, 2023</time>
					</p>
					<svg
							viewBox="0 0 2 2"
							class="size-0.5 fill-current">
						<circle
								cx="1"
								cy="1"
								r="1" />
					</svg>
					<p class="truncate">Created by Leslie Alexander</p>
				</div>
			</div>
			<div class="min-w-0">
				<div class="flex items-start gap-x-3">
					<p class="text-sm/6 font-semibold text-gray-900 dark:text-slate-300">Secondary Demand</p>
				</div>
				<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
					<div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
						<p class="whitespace-nowrap text-gray-500 dark:text-slate-300">Not Requested Yet
						</p>
					</div>
				</div>
			</div>
			<div
					class="flex flex-none items-center gap-x-4"
					x-data="{ open: false }"
					@click.away="open = false">
				<span class="sr-only">, GraphQL API</span>
				<div class="relative flex-none">
					<x-dropdown.dropdown>
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
						<x-slot:content>
							<div
									class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none"
									role="menu"
									aria-orientation="vertical"
									aria-labelledby="options-menu-0-button"
									tabindex="-1">
								<!-- Active: "bg-gray-50 outline-none", Not Active: "" -->
								<a
										href="#"
										class="block px-3 py-1 text-sm/6 text-gray-900"
										role="menuitem"
										tabindex="-1"
										id="options-menu-0-item-0">Request<span class="sr-only">, GraphQL API</span></a>
								<a
										href="#"
										class="block px-3 py-1 text-sm/6 text-gray-900"
										role="menuitem"
										tabindex="-1"
										id="options-menu-0-item-1">Delete<span class="sr-only">, GraphQL API</span></a>
							</div>
						</x-slot:content>
					</x-dropdown.dropdown>


					<!--
					  Dropdown menu, show/hide based on menu state.

					  Entering: "transition ease-out duration-100"
						From: "transform opacity-0 scale-95"
						To: "transform opacity-100 scale-100"
					  Leaving: "transition ease-in duration-75"
						From: "transform opacity-100 scale-100"
						To: "transform opacity-0 scale-95"
					-->

				</div>
			</div>
		</li>
	</ul>
</div>
