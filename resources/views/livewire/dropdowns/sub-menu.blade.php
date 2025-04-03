<div
		class="relative"
		x-data="{ submenu: false }">
	<x-dropdown.dropdown-button
			@click="submenu = !submenu"
			class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
		<div class="flex items-center justify-between">
            <span>
                {{ $buttonLabel }}
            </span>
			<span>
                <x-heroicons::solid.chevron-right class="w-3 h-3 text-gray-900 dark:text-gray-300" />
            </span>
		</div>
	</x-dropdown.dropdown-button>

	<!-- Submenu Dropdown -->
	@if($buttonLabel === 'New Private Chat')
		<div
				x-show="submenu"
				class="absolute left-full ml-3 top-0 w-80 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5"
				@click.away="submenu = false">
			@if(!empty($activeUsers))
				@foreach ($activeUsers as $user)
					@if ($user['id'] !== auth()->id())
						<!-- Exclude the current user -->
						<x-dropdown.dropdown-button
								wire:click="sendPrivateInvitation({{ $user['id'] }})"
								class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
							<div class="flex items-center justify-between">
								<div class="flex items-center space-x-2">
									<img
											class="w-8 h-8 rounded-full"
											src="{{ $user['avatar'] }}"
											alt="User Avatar">
									<div>
										<div>{{ $user['name'] }}</div>
										<span class="block text-xs text-gray-500">{{ $user['role'] }}</span>
									</div>
								</div>
								@if (session('user_message_' . $user['id']))
									<div class="text-emerald-400 text-xs font-semibold">
										{{ session('user_message_' . $user['id']) }}
									</div>
								@endif
							</div>
						</x-dropdown.dropdown-button>
					@endif
				@endforeach
			@else
				<div class="text-start text-sm leading-5 text-gray-700 px-4 py-2 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
					No Users Yet
				</div>
			@endif
		</div>
	@else
		<div
				x-show="submenu"
				class="absolute py-4 left-full ml-3 top-0 w-80 bg-white rounded shadow-lg ring-1 ring-black ring-opacity-5"
				@click.away="submenu = false">
			@if(!empty($activeUsers))
				@foreach ($activeUsers as $user)
					<div
							role="button"
							wire:click="toggleUserSelection({{ $user['id'] }})"
							class="block px-4 py-2 text-gray-700 hover:bg-gray-100 cursor-pointer {{ in_array($user['id'], $selectedUsers) ? 'bg-teal-100' : '' }}">
						<div class="flex items-center justify-between">
							<div class="flex items-center space-x-2">
								<img
										class="w-8 h-8 rounded-full"
										src="{{ $user['avatar'] }}"
										alt="User Avatar">
								<div>
									<div>{{ $user['name'] }}</div>
									<span class="block text-xs text-gray-500">{{ $user['role'] }}</span>
								</div>
							</div>
							@if (in_array($user['id'], $selectedUsers))
								<x-heroicons::solid.check-circle class="w-4 h-4 text-emerald-500" />
							@endif
						</div>
					</div>
				@endforeach

				<div class="mt-4 px-4">

					<x-buttons.small-primary
							wire:click="sendGroupInvitation({{ json_encode($selectedUsers) }})"
							class="bg-indigo-500 hover:bg-indigo-600">
						Invite Selected ({{ count($selectedUsers) }})
					</x-buttons.small-primary>
				</div>
			@else
				<div class="text-start text-sm leading-5 text-gray-700 px-4 py-2 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
					No Users Available
				</div>
			@endif
		</div>
	@endif
</div>
