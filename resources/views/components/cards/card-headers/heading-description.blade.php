@props(['heading' => 'Card heading'])
<div class="border-b border-gray-200 bg-white px-4 py-5 sm:px-6">
	<div class="-mt-4 -ml-4 flex flex-wrap items-center justify-between sm:flex-nowrap">
		<div class="mt-4 ml-4">
			<h3 class="text-base font-semibold text-gray-500 uppercase">{{ $heading }}</h3>
			<p class="mt-1 text-sm text-gray-500">{{ $slot }}</p>
		</div>
	</div>
</div>