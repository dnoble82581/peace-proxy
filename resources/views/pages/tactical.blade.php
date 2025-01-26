<x-tactical-layout>
	<div
			x-data="{ tab: 'map' }"
			class="p-10">
		<!-- Alerts -->
		<div class="rounded-lg shadow-md">
			<livewire:alerts.tactical-alerts :room="$room" />
		</div>

		<!-- General Information -->
		<div class="flex items-center gap-3 mt-5">
			<div class="flex-1">
				<livewire:negotiations.negotiation-subject :room="$room" />
			</div>

			<div class="flex-1">
				<livewire:negotiations.negotiation-information :room="$room" />
			</div>
		</div>

		<!-- Tab Navigation -->
		<div class="mb-5 mt-5 flex gap-5 items-center">
			<div class="flex-1 flex gap-3 items-center">
				<x-input
						id="query-input"
						value="{{ $room->negotiation->address }}"
						placeholder="Search" />
				<x-button
						id="search-button"
						label="Search" />
			</div>

			<!-- x-navigation.tab-navigation -->
			<div class="flex-1">
				<div>
					<div class="grid grid-cols-1 sm:hidden">
						<!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
						<select
								aria-label="Select a tab"
								class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
							<option>My Account</option>
							<option>Company</option>
							<option selected>Team Members</option>
							<option>Billing</option>
						</select>
						<svg
								class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500"
								viewBox="0 0 16 16"
								fill="currentColor"
								aria-hidden="true"
								data-slot="icon">
							<path
									fill-rule="evenodd"
									d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
									clip-rule="evenodd" />
						</svg>
					</div>
					<div class="hidden sm:block">
						<div class="border-b border-gray-200">
							<nav
									class="-mb-px flex space-x-8"
									aria-label="Tabs">
								<!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
								<button
										@click="tab = 'map'"
										type="button"
										class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
										:class="tab === 'map' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'">
									<!-- Current: "text-indigo-500", Default: "text-gray-400 group-hover:text-gray-500" -->
									<svg
											class="mr-2 -ml-0.5 size-5 text-gray-400 group-hover:text-gray-500"
											:class="tab === 'map' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path d="M10 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM3.465 14.493a1.23 1.23 0 0 0 .41 1.412A9.957 9.957 0 0 0 10 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 0 0-13.074.003Z" />
									</svg>
									<span>Map</span>
								</button>
								<button
										@click="tab = 'communication'"
										type="button"
										class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
										:class="tab === 'communication' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
								>
									<svg
											class="mr-2 -ml-0.5 size-5 group-hover:text-gray-500"
											:class="tab === 'communication' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path
												fill-rule="evenodd"
												d="M4 16.5v-13h-.25a.75.75 0 0 1 0-1.5h12.5a.75.75 0 0 1 0 1.5H16v13h.25a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75v-2.5a.75.75 0 0 0-.75-.75h-2.5a.75.75 0 0 0-.75.75v2.5a.75.75 0 0 1-.75.75h-3.5a.75.75 0 0 1 0-1.5H4Zm3-11a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 9a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM11 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm.5 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z"
												clip-rule="evenodd" />
									</svg>
									<span>Communication</span>
								</button>
								<button
										@click="tab = 'team'"
										type="button"
										class="group inline-flex items-center border-b-2 px-1 py-4 text-sm font-medium"
										:class="tab === 'team' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'"
										aria-current="page">
									<svg
											class="mr-2 -ml-0.5 size-5"
											:class="tab === 'team' ? 'text-indigo-500' : 'text-gray-400 group-hover:text-gray-500'"
											viewBox="0 0 20 20"
											fill="currentColor"
											aria-hidden="true"
											data-slot="icon">
										<path d="M7 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM14.5 9a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM1.615 16.428a1.224 1.224 0 0 1-.569-1.175 6.002 6.002 0 0 1 11.908 0c.058.467-.172.92-.57 1.174A9.953 9.953 0 0 1 7 18a9.953 9.953 0 0 1-5.385-1.572ZM14.5 16h-.106c.07-.297.088-.611.048-.933a7.47 7.47 0 0 0-1.588-3.755 4.502 4.502 0 0 1 5.874 2.636.818.818 0 0 1-.36.98A7.465 7.465 0 0 1 14.5 16Z" />
									</svg>
									<span>Team Members</span>
								</button>
							</nav>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Map Section -->
		<div class="flex gap-5 mt-5">
			<!-- Main Map -->
			<div
					id="map"
					class="w-1/2 h-[40rem] rounded-lg shadow-lg">
			</div>
			<!-- Second Map -->
			<div
					x-show="tab === 'map'"
					x-cloak
					id="map-2"
					class="w-1/2 h-[40rem] rounded-lg shadow-lg">
			</div>
			<div
					class="flex-1"
					x-cloak
					x-show="tab === 'communication'">
				<div class="flex gap-5">
					<div class="flex-1">
						Second thing
					</div>
					<div class="flex-1">
						<x-navigation.tab-navigation
								container-class="sm:col-span-3 bg-white"
								:tabs="[
                    ['key' => 'public', 'label' => 'Public'],
                    ['key' => 'private', 'label' => 'Private'],
                    ['key' => 'tactical', 'label' => 'Tactical'],
                ]"
								:default-tab="'tactical'">

							<div
									x-show="tab === 'public'">
								<livewire:negotiations.negotiation-chat
										:room="$room"
										:toTactical="false"
										:isPrivate="false" />
							</div>
							<div x-show="tab === 'private'">
								<livewire:negotiations.negotiation-chat
										:room="$room"
										:toTactical="false"
										:isPrivate="true" />
							</div>
							<div x-show="tab === 'tactical'">
								<livewire:negotiations.negotiation-chat
										:room="$room"
										:toTactical="true"
										:isPrivate="false" />
							</div>
						</x-navigation.tab-navigation>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-tactical-layout>