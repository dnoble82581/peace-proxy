<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-[#252525] px-4 shadow-xs sm:gap-x-6 sm:px-6 lg:px-8">
	<button
			type="button"
			class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
		<span class="sr-only">Open sidebar</span>
		<svg
				class="size-6"
				fill="none"
				viewBox="0 0 24 24"
				stroke-width="1.5"
				stroke="currentColor"
				aria-hidden="true"
				data-slot="icon">
			<path
					stroke-linecap="round"
					stroke-linejoin="round"
					d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
		</svg>
	</button>

	<!-- Separator -->
	<div
			class="h-6 w-px bg-gray-900/10 lg:hidden"
			aria-hidden="true"></div>

	<div class="flex flex-1 items-center justify-between lg:gap-x-6">
		<div class="">
			<a
					href="{{ route('dashboard') }}
"
					class="flex items-center gap-1 text-sm/6 text-white hover:text-gray-700">
				<x-heroicons::micro.solid.arrow-left class="" />
				Back</a>
		</div>
		<div class="flex items-center gap-x-4 lg:gap-x-6">
			<button
					type="button"
					class="-m-2.5 p-2.5 text-gray-400 hover:text-gray-500">
				<span class="sr-only">View notifications</span>
				<svg
						class="size-6"
						fill="none"
						viewBox="0 0 24 24"
						stroke-width="1.5"
						stroke="currentColor"
						aria-hidden="true"
						data-slot="icon">
					<path
							stroke-linecap="round"
							stroke-linejoin="round"
							d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
				</svg>
			</button>

			<!-- Separator -->
			<div
					class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"
					aria-hidden="true"></div>

			<!-- Profile dropdown -->
			<div class="relative">
				<x-dropdown.dropdown>
					<x-slot:trigger>
						<button
								type="button"
								class="-m-1.5 flex items-center p-1.5"
								id="user-menu-button"
								aria-expanded="false"
								aria-haspopup="true">
							<span class="sr-only">Open user menu</span>

							<img
									class="size-8 rounded-full"
									src="{{ $tenant->logoUrl() }}"
									alt="">
							<span class="hidden lg:flex lg:items-center">
                <span
		                class="ml-4 text-sm/6 font-semibold text-white"
		                aria-hidden="true">{{ $user->name }}</span>

               <x-heroicons::micro.solid.chevron-down class="w-5 h-5 ml-2 text-gray-400" />
              </span>
						</button>
					</x-slot:trigger>
					<x-slot:content>

						<!-- Active: "bg-gray-50 outline-hidden", Not Active: "" -->
						<a
								href="{{ route('profile') }}"
								class="block px-3 py-1 text-sm/6 text-gray-900"
								role="menuitem"
								tabindex="-1"
								id="user-menu-item-0">Your profile</a>
						<form
								method="POST"
								action="{{ route('logout') }}">
							@csrf
							<button
									type="submit"
									class="block px-3 py-1 text-sm text-gray-900"
									role="menuitem"
									id="user-menu-item-1">Sign out
							</button>
						</form>

					</x-slot:content>
				</x-dropdown.dropdown>
			</div>
		</div>
	</div>
</div>