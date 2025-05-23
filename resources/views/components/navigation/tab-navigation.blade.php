<div
		x-data="{ tab: '{{ $defaultTab }}' }"
		class="{{ $containerClass }}">
	<!-- Tabs -->
	<div class="p-4 border-b bg-white border-gray-200 rounded-t-lg dark:border-gray-700 dark:bg-gray-800">

		<nav
				class="flex space-x-4"
				aria-label="Tabs">
			@foreach ($tabs as $key => $tab)
				<button
						@click="tab = '{{ $tab['key'] }}'"
						type="button"
						:class="tab === '{{ $tab['key'] }}'
                        ? 'rounded-md bg-indigo-100 px-3 py-2 text-sm font-medium text-indigo-700'
                        : 'dark-light-text text-sm px-3 font-medium hover:text-gray-700'">
					{{ $tab['label'] }}
				</button>
			@endforeach
		</nav>
	</div>

	<!-- Tab Content -->
	<div class="dark:bg-gray-800">
		{{ $slot }}
	</div>
</div>