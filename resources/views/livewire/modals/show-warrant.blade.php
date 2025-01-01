<div class="p-8 dark:bg-gray-800">
	<div class="px-4 sm:px-0">
		<h3 class="text-base/7 font-semibold text-gray-900 dark-light-text">Warrant Information</h3>
		<p class="mt-1 max-w-2xl text-sm/6 text-gray-500 dark-light-text">Personal details and application.</p>
	</div>
	<div class="mt-6 border-t border-gray-100">
		<dl class="divide-y divide-gray-100">
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Offense</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->offense }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Originating Agency</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->originating_agency }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Originating County</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->originating_county }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Originating State</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->originating_state }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Extraditable</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->extraditable }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Date Entered</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->entered_on }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Confirmed</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->confirmed }}</dd>
			</div>
			<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
				<dt class="text-sm/6 font-medium text-gray-900 dark-light-text">Notes</dt>
				<dd class="mt-1 text-sm/6 text-gray-700 sm:col-span-2 sm:mt-0 dark-light-text">{{ $warrant->notes }}</dd>
			</div>
		</dl>
	</div>
</div>


