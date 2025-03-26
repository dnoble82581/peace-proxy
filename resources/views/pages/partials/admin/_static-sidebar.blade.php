<div

		class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
	<!-- Sidebar component, swap this element with another sidebar if you like -->
	<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-[#1a1a1b] px-6 pb-4">
		<div class="flex h-16 shrink-0 items-center">
			<a href="{{ route('dashboard') }}">
				<x-svg-images.application-logo class="shrink-0 h-10 w-auto fill-white" />
			</a>
		</div>
		<nav class="flex flex-1 flex-col">
			<ul
					role="list"
					class="flex flex-1 flex-col gap-y-7">
				<li>
					<ul
							role="list"
							class="-mx-2 space-y-1">
						<li>
							<!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
							<button
									@click="tab = 'dashboard'"
									:class="{ 'bg-[#252525] text-white': tab === 'dashboard' }"
									class="group flex gap-x-3 w-full rounded-md p-2 text-sm/6 font-semibold text-gray-400">
								<x-heroicons::outline.home class="size-6 shrink-0" />
								Dashboard
							</button>
						</li>
						<li>
							<button
									@click="tab = 'team'"
									:class="{ 'bg-[#252525] text-white': tab === 'team' }"
									class="group w-full flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400">
								<x-heroicons::outline.user-group class="size-6 shrink-0" />
								Team
							</button>
						</li>
						<li>
							<button
									@click="tab = 'negotiations'"
									:class="{ 'bg-[#252525] text-white': tab === 'negotiations' }"
									class="group w-full flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400">
								<x-heroicons::outline.document-duplicate class="size-6 shrink-0" />
								Negotiations
							</button>
						</li>
						<li>
							<button
									@click="tab = 'reports'"
									:class="{ 'bg-[#252525] text-white': tab === 'reports' }"
									class="group w-full flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400">
								<x-heroicons::outline.chart-pie class="size-6 shrink-0" />
								Reports
							</button>
						</li>
					</ul>
				</li>
				<li>
					<div class="text-xs/6 font-semibold text-gray-400">Your teams</div>
					<ul
							role="list"
							class="-mx-2 mt-2 space-y-1">
						<li>
							<!-- Current: "bg-gray-800 text-white", Default: "text-gray-400 hover:text-white hover:bg-gray-800" -->
							<a
									href="#"
									class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-gray-800 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">H</span>
								<span class="truncate">Heroicons</span>
							</a>
						</li>
						<li>
							<a
									href="#"
									class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-gray-800 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">T</span>
								<span class="truncate">Tailwind Labs</span>
							</a>
						</li>
						<li>
							<a
									href="#"
									class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-gray-800 hover:text-white">
								<span class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-700 bg-gray-800 text-[0.625rem] font-medium text-gray-400 group-hover:text-white">W</span>
								<span class="truncate">Workcation</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="mt-auto">
					<button
							@click="tab = 'settings'"
							:class="{ 'bg-[#252525] text-white': tab === 'settings' }"
							class="group w-full flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400">
						<x-heroicons::outline.cog-6-tooth class="size-6 shrink-0" />
						Settings
					</button>
				</li>
			</ul>
		</nav>
	</div>
</div>