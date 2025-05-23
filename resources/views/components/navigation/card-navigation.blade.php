@props(['labels' => [], 'contentClasses' => ''])
<div>
	<div class="grid grid-cols-1 sm:hidden">
		<!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
		<select
				aria-label="Select a tab"
				class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
			@foreach($labels as $label)
				<option>{{ $label }}</option>
			@endforeach
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
					class="-mb-px flex {{ $contentClasses }} space-x-8"
					aria-label="Tabs">
				<!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700" -->
				{{ $content }}
			</nav>
		</div>
	</div>
</div>
