<div class="rounded-lg bg-white dark:bg-gray-800 col-span-12">
	<div class="px-4 py-5 sm:p-6 grid grid-cols-12 gap-4">
		<div class="rounded-lg shadow col-span-6 dark:bg-gray-700">
			<div class="px-4 py-5 sm:p-6 relative">
				<div class="flex gap-5 justify-evenly">
					<div class="absolute top-2 right-2">
						<x-dropdown.dropdown>
							<x-slot:trigger>
								<button>
									<x-heroicons::mini.solid.ellipsis-vertical class="w-6 h-6 text-gray-400" />
								</button>
							</x-slot:trigger>
							<x-slot:content>
								<div>
									<x-dropdown.dropdown-link>Add Warrant</x-dropdown.dropdown-link>
									<x-dropdown.dropdown-link>Edit</x-dropdown.dropdown-link>
									<x-dropdown.dropdown-link>View</x-dropdown.dropdown-link>
								</div>
							</x-slot:content>
						</x-dropdown.dropdown>

					</div>
					<div>
								<span class="inline-block size-14 rounded bg-gray-100">
                                <svg
		                                class="size-full text-gray-300"
		                                fill="currentColor"
		                                viewBox="0 0 24 24">
                                 <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
								</span>
					</div>
					<div class="text-sm text-gray-600 dark:text-slate-300">
						<strong class="block">Dusty Noble</strong>
						<span class="block">18881 Curtis Bridge Road NE</span>
						<span class="block">(319)-594-7290</span>
					</div>
					<div class="text-sm text-gray-600 dark:text-slate-300">
						<strong class="block">Deadlines</strong>
						<span class="block">Beer and Cigaretts</span>
						<span class="block">Due in 3 hours</span>
					</div>

					<div class="text-sm text-gray-600 dark:text-slate-300">
						<strong class="block">Mood</strong>
						<span class="block">12/12/2024 at 17:45pm</span>
						<span class="block">Trending Up</span>
					</div>
				</div>
				<div class="grid grid-cols-8 gap-5 items-center">
					<div class="p-4 flex gap-5 col-span-3">
						<x-svg-images.social.facebook-icon class="w-6 h-6" />
						<x-svg-images.social.instagram-icon class="w-6 h-6" />
						<x-svg-images.social.snapchat-icon class="w-6 h-6" />
						<x-svg-images.social.x-icon class="w-6 h-6" />
						<x-svg-images.social.youtube-icon class="w-6 h-6" />
					</div>
					<div class="col-span-5">
						<div class="flex items-center gap-2">
							<button
									type="button"
									class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
								Warrants(4)
							</button>
							<button
									type="button"
									class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
								Button text
							</button>
							<button
									type="button"
									class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
								Button text
							</button>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="overflow-hidden rounded-lg shadow col-span-6 dark:bg-gray-700">
			<div class="px-4 py-5 sm:p-6">
				<div class="flex gap-5 justify-between">
					<div class="max-w-md flex-1">
						<strong class="text-sm text-gray-600 dark:text-slate-300">Initial Complaint</strong>
						<p class="max-w-prose text-sm text-gray-600 dark:text-slate-300">Lorem ipsum dolor sit
						                                                                 amet, consectetur
						                                                                 adipisicing
						                                                                 elit. Animi at, dolores
						                                                                 eius
						                                                                 eveniet minima minus
						                                                                 odio quis quod
						                                                                 repellendus sed,
						                                                                 tempora voluptas
						                                                                 voluptatibus
						                                                                 voluptatum!
						                                                                 Exercitationem pariatur
						                                                                 quasi
						                                                                 quia
						                                                                 sed
						                                                                 vel!</p>
					</div>
					<div class="text-sm text-gray-600 flex-1 dark:text-slate-300">
						<strong class="block">Notes</strong>
						<p class="max-w-prose">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque
						                       consectetur
						                       esse est
						                       fugiat nam quaerat, sapiente tempora veritatis. Amet ducimus
						                       facere facilis,
						                       harum
						                       labore obcaecati quidem repudiandae. Est reprehenderit,
						                       voluptatem.</p>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>